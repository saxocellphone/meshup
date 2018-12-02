<?php

namespace app\library;

use app\model\User;
use app\model\Connection;

/**
 * Class DatabaseQueries
 *
 * Contains needed operations regarding the database
 */
class DatabaseQueries {

    protected $core;

    protected $course_db;

    private $meshup_db = NULL;
    private $user = NULL;

    public function __construct(Core $core) {
        $this->core = $core;
    }

    /**
     * Connects to database, ideally in another class
     */
    public function connect(){
        $servername = "localhost";
        $username = "root";
        $password = "horsecupmeatpump";
        $db_name = "meshup";

        $conn = mysqli_connect($servername, $username, $password, $db_name);
        if($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $this->meshup_db = $conn;
    }

    /**
     * Gets all the users in the network in json
     */
    public function getUsersJSON(){
        $sql = "SELECT username, first_name, last_name, profession from users";
        $result = $this->meshup_db->query($sql);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return json_encode($rows);
    }

    public function checkUserExist($username){
        // Need to fix this to prevent sql injection
        $sql = "SELECT username FROM users WHERE username = '" . $username . "'";
        $result = $this->meshup_db->query($sql);
        return $result->num_rows > 0;
    }

    public function makeAccount($attrs = array()){
        $cols = implode('", "', $attrs);
        $sql = "INSERT INTO users ( username, password, first_name, last_name, profession ) VALUES ( \"$cols\" )";
        return $this->meshup_db->query($sql);
    }

    /**
     * Check if username and password match
     */

    public function checkUser(String $username, String $password){
        $sql = "SELECT username, password FROM users WHERE username = '$username'";
        $result = $this->meshup_db->query($sql);
        if(!$result->num_rows > 0){
            return array('msg' => 'User does not exist!', 'status' => false);
        }  else {
            $row = $result->fetch_assoc();
            if($row['password'] == $password){
                return array('msg' => 'Success!', 'status' => true);
            } else {
                return array('msg' => 'Username or password does not match.', 'status' => false);
            }
        }
    }

    /**
     * Returns rows of only unseen connection requests, for the purpose of update.
     */
    public function getNewConnectionRequests(User $user){
        $username = $user->username;
        $sql = "SELECT connect_from, time_stamp FROM adding_queue WHERE connect_to = '$username' and viewed = 0";
        $result = $this->meshup_db->query($sql);
        
        $sql = "UPDATE adding_queue SET viewed = 1 WHERE connect_to = '$username'";
        $this->meshup_db->query($sql);
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    public function getNewEdges(User $user){
        $time_updated = $user->last_update;
        $count = $this->numberConnections();
        $diff = $count - $_SESSION['total_connection'];
        if($diff != 0){
            $sql = "SELECT first_username, second_username FROM `connections` ORDER BY time_stamp DESC LIMIT {$diff}";
            $result = $this->meshup_db->query($sql);
            $new_edges = array();
            while($row = mysqli_fetch_assoc($result)){
                $new_edges[] = new Connection($this->core, $row);
            }
            $_SESSION['total_connection'] = $count;
            return $new_edges;
        } else {
            return array();
        }
    }

    public function numberConnections(){
        $sql = "SELECT COUNT(*) as count FROM `connections`";
        $count = intval($this->meshup_db->query($sql)->fetch_assoc()['count']);
        return $count;
    }

    /**
     * Try adding connection to adding queue
     */
    public function addToConnectionQueue(User $user1, User $user2){
        $user1_username = $user1->username;
        $user2_username = $user2->username;
        if($this->checkConnectionExist($user1_username, $user2_username)){
            return array('msg' => 'Connection already established!', 'status' => false);
        } else {
            switch($this->checkRequestExist($user1_username, $user2_username)){
                case 0:
                    $sql = "INSERT INTO adding_queue (connect_from, connect_to) VALUES ('$user1_username', '$user2_username')";
                    $this->meshup_db->query($sql);
                    return array('msg' => 'Added request to queue.', 'status' => true);
                    break;
                case 1:
                    return array('msg' => 'Already sent a request.', 'status' => false);
                    break;
                case 2:
                    return $this->connectTwo($user1, $user2);
                    break;
            }
        }
    }

    /**
     * Remove recard from queue if the request is rejected.
     */
    public function removeFromConnectionQueue(User $sender, User $receiver){
        $sql = "DELETE FROM adding_queue WHERE (connect_from = '$sender->username' and connect_to = '$receiver->username')";
        $this->meshup_db->query($sql);
        return array('status' => true);
    }

    /**
     * Try to connect two nodes together in the connections table
     */
    public function connectTwo(User $user1, User $user2){
        $user1_username = $user1->username;
        $user2_username = $user2->username;
        if($this->checkConnectionExist($user1_username, $user2_username)){
            return array('msg' => 'Connection already established!', 'status' => false);
        } else {
            switch($this->checkRequestExist($user1_username, $user2_username)){
                case 0:
                    return array('msg' => 'The person did not send a request', 'status' => false);
                    break;
                default:
                    $this->removeFromConnectionQueue($user1, $user2);
                    $this->removeFromConnectionQueue($user2, $user1);
                    break;
            }
            $sql = "INSERT INTO connections (first_username, second_username) VALUES ('$user1_username', '$user2_username')";
            $sql2 = "INSERT INTO connections (second_username, first_username) VALUES ('$user1_username', '$user2_username')";
            $this->meshup_db->query($sql);
            $this->meshup_db->query($sql2);
            return array('msg' => 'Connected ' . $user1_username . ' with '. $user2_username . ".", 'status' => true);
        }
    }

    /**
     * Returns a status code 
     * 0: does not exist
     * 1: user1 already sent a request
     * 2: user2 already sent user1 a request
     */

    public function checkRequestExist(String $name1, String $name2){
        $sql = "SELECT * FROM adding_queue WHERE (connect_from = '$name1' AND connect_to = '$name2')";
        $result = $this->meshup_db->query($sql);
        if($result->num_rows > 0){
            return 1;
        }
        $sql = "SELECT * FROM adding_queue WHERE (connect_from = '$name2' AND connect_to = '$name1')";
        $result = $this->meshup_db->query($sql);
        if($result->num_rows > 0){
            return 2;
        }
        return 0;
    }

    public function checkConnectionExist(String $name1, String $name2){
        $sql = "SELECT * FROM connections WHERE (first_username = '$name1' AND second_username = '$name2')";
        $result = $this->meshup_db->query($sql);
        return $result->num_rows > 0;
    }

    /**
     * @param String username
     * 
     * @return User An User model
     */
    public function getMeshupUser(String $username){
        $sql = "SELECT users.*, GROUP_CONCAT(connections.second_username) as connections FROM users LEFT JOIN connections ON users.username = connections.first_username WHERE users.username = '$username'";
        $result = $this->meshup_db->query($sql);
        if(!$result->num_rows > 0){
            return null;
        } else {
            $row = $result->fetch_assoc();
            return new User($this->core, $row);
        }
    }

    public function getMeshupEdge(){
        $sql = "SELECT * FROM connections";
        $result = $this->meshup_db->query($sql);
        $edges = array();
        while($row = mysqli_fetch_assoc($result)){
            $edges[] = new Connection($this->core, $row);
        }
        return $edges;
    }

    public function getMeshupUsers(){
        $sql = "SELECT users.*, GROUP_CONCAT(connections.second_username) as connections FROM users LEFT JOIN connections ON users.username = connections.first_username GROUP BY users.username";
        $result = $this->meshup_db->query($sql);
        $users = array();
        while($row = mysqli_fetch_assoc($result)){
            $users[] = new User($this->core, $row);
        }
        return $users;
    }
}
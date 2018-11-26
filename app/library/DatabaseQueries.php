<?php

namespace app\library;

/**
 * Class DatabaseQueries
 *
 * Contains needed operations regarding the database
 */
class DatabaseQueries {

    protected $core;

    protected $course_db;

    private $meshup_db = NULL;

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

    public function checkUser($username, $password){
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
}
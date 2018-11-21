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
        $password = "";
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
    public function getUsers(){
        $sql = "SELECT * from users";
        $result = $this->meshup_db->query($sql);
        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return json_encode($rows);
    }
}
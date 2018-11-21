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
     * Gets all the users in the network
     */
    public function getUsers(){
        $sql = "SELECT * from users";
        $result = $this->meshup_db->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
            }
        } else {
            echo "0 results";
        }
    }
}
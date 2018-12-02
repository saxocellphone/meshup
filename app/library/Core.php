<?php

namespace app\library;

use app\library\DatabaseQueries;
use app\model\Graph;
/**
 * Class core
 *
 * Core of the application that acts as a middle man to other libraries.
 */
class Core {
    private $db = NULL;

    private $user;
    private $graph;

    public function __construct() {
        $this->output = "";
    }  

    public function getOutput() {
        return $this->output;
    }

    public function renderOutput($output) {
        $this->output .= $output;
    }

    public function renderJSON($json){
        $this->output = json_encode($json);
    }

    public function renderJSONSuccess($json){
        $response = [
            'status' => 'success',
            'json' => $json
        ];
        $this->renderJSON($response);
        return $response;
    }

    public function renderJSONError($json){
        $response = [
            'status' => 'error',
            'json' => $json
        ];
        $this->renderJSON($response);
        return $response;
    }

    public function displayOutput(){
        echo($this->getOutput());
    }

    public function loadDatabase(){
        $this->db = new DatabaseQueries($this);
        $this->db->connect();
        // MOVE THIS
        $num_connections = $this->db->numberConnections();
        $this->graph = new Graph($this, array("total_connections" => $num_connections));
    }

    public function redirect($url){
        header('Location: ' . $url);
        die();
    }

    public function getDB(){
        return $this->db;
    }

    /**
     * This function is called whenever you log in
     */
    public function loadUser($userid){
        $this->user = $this->db->getMeshupUser($userid);
    }

    public function getGraph(){
        return $this->graph;
    }

    public function getUser(){
        return $this->user;
    }
}
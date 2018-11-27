<?php

namespace app\library;

use app\library\DatabaseQueries;
/**
 * Class core
 *
 * Core of the application that acts as a middle man to other libraries.
 */
class Core {
    private $db = NULL;

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
        // $this->renderJSON($response);
        return $response;
    }

    public function renderJSONError($json){
        $response = [
            'status' => 'error',
            'json' => $json
        ];
        $this->render/JSON($response);
        return $response;
    }

    public function displayOutput(){
        echo($this->getOutput());
    }

    public function loadDatabase(){
        $this->db = new DatabaseQueries($this);
        $this->db->connect();
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

    public function getUser(){
        return $this->user;
    }
}
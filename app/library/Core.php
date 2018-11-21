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

    public function displayOutput(){
        echo($this->getOutput());
    }

    public function loadDatabase(){
        $this->db = new DatabaseQueries($this);
        $this->db->connect();
    }

    public function getDB(){
        return $this->db;
    }
}
<?php

namespace app\library;

/**
 * Class core
 *
 * Core of the application that acts as a middle man to other libraries.
 */
class Core {
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
}
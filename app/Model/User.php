<?php
namespace app\model;

use app\library\Core;

class User{
    private $first_name;
    private $last_name;
    private $username;
    private $profession;

    private $connections = [];
    
    private $core;
    public function __construct(Core $core, $details=array()) {
        $this->core = $core;
        $this->first_name = $details['first_name'];
        $this->last_name = $details['last_name'];
        $this->profession = $details['profession'];        
        $this->username = $details['username'];
    }

    /**
     * Magic getter that gets private variables.
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
    }
}
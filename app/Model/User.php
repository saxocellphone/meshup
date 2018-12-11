<?php
namespace app\model;

use app\library\Core;

class User{
    private $first_name;
    private $last_name;
    private $username;
    private $profession;

    private $last_update;

    // Should switch to connection model
    private $connections;

    private $core;
    public function __construct(Core $core, $details=array()) {
        $this->core = $core;
        $this->first_name = $details['first_name'];
        $this->last_name = $details['last_name'];
        $this->profession = $details['profession'];        
        $this->username = $details['username'];
        $this->connections = explode(', ', $details['connections']) ?? array();
        $this->last_update = date("Y-m-d H:i:s",time());
    }

    /**
     * @param User $user2 User object of the user to connect to.
     * 
     * Attemps to connect two nodes
     * 
     * @return Array Status of adding
     */

    public function connectTo(User $user2){
        if(in_array($user2, $this->connections)){
            $this->core->renderJSONError('Connection already established.');
            return false;
        }
        $this->connections[] = $user2;
        return $this->core->getDB()->connectTwo($this->core->getUser(), $user2);
    }

    /**
     * This helps to update undetected changes since last update
     */
    public function renewUpdate(){
        $this->last_upddate = date("Y-m-d H:i:s",time());
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
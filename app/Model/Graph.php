<?php
namespace app\model;

use app\library\Core;

class Graph{
    private $core;

    private $total_connections;
    public function __construct(Core $core, $details=array()) {
        $this->core = $core;
        $this->total_connections = $details['total_connections'] ?? 0;
    }

    public function addConnection(){
        $this->total_connections = $this->total_connections + 2;
    }
    
    public function setConnections($num){
        $this->total_connections = $num;
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
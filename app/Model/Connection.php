<?php
namespace app\model;

use app\library\Core;

class Connection{
    private $core;

    private $first_user;
    private $second_user;

    public function __construct(Core $core, $details=array()){
        $this->core = $core;
        // var_dump($details);
        $this->first_user = $details['first_username'];
        $this->second_user = $details['second_username'];
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
    }

}
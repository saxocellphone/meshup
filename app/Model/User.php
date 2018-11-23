<?php
namespace app\models;

use app\libraries\Core;

class User{
    private $first_name;
    private $last_name;
    private $password;
    private $profession;

    private $connections = []
    
    private $core;
    public function __construct(Core $core, $details=array()) {
        $this->core = $core;
        

    }
}
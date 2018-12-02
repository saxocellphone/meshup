<?php
namespace app\model;

use app\library\Core;

class Connection{
    private $core;

    private $first_user;
    private $second_user;

    public function __construct(Core $core, $details=array()){
        $this->$core = $core;
        $first_user = $details['first_user'];
        $second_user = $details['second_user'];
    }

}
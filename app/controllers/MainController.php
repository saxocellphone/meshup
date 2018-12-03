<?php

namespace app\controllers;

use app\library\Core;
use app\views\MainView;
use app\views\SettingView;

class MainController {
    
    /** @var Core */
    protected $core;
    
    /** @var MainView */
    protected $view;
    
    public function __construct(Core $core) {
        $this->core = $core;
        $this->view = new MainView($core);
    }

    public function run() {
        if(!$_SESSION['logged_in']){
            echo "You don't have access";
            return false;
        }
        $username = $_SESSION['username'];
        $this->core->loadUser($username);
        switch($_REQUEST['page']){
            case 'user_setting':
                $this->showSettingView();
                break;
            default:
                $this->showMainView();
                break;
        }
    }

    public function showSettingView(){
        $this->view = new SettingView($this->core);
        $this->core->renderOutput($this->view->showSettingView());
    }

    public function showMainView(){
        $this->view = new MainView($this->core);
        if($this->core->getUser() != NULL){
            //TODO: Switch to getusers, and delete getUserJSON
            $users = $this->core->getDB()->getMeshupUsers();
            $graph = array();
            // var_dump($users);
            for($i = 0; $i < count($users); $i++){
                $attr = array();
                $attr['firstname'] = $users[$i]->first_name;
                $attr['lastname'] = $users[$i]->last_name;
                $attr['profession'] = $users[$i]->profession;
                $attr['connections'] = $users[$i]->connections;
                $graph[$users[$i]->username] = $attr;
            }
            $this->core->renderOutput($this->view->showMainApp(json_encode($graph)));
        } else {
            echo "Something went wrong";
            return false;
        }
    }
    
}
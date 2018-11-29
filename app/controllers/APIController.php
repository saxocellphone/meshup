<?php

namespace app\controllers;

use app\library\Core;

class APIController {
    
    /** @var Core */
    protected $core;
    
    public function __construct(Core $core) {
        $core->loadUser($_SESSION['username']);
        $this->core = $core;
    }

    public function run() {
        if(!$_SESSION['logged_in']){
            echo "You don't have access";
            return false;
        }
        switch($_REQUEST['function']){
            case 'add_to_connect_queue':
                $this->addToQueue();
                break;
            case 'get_status':
                $this->getStatus();
                break;
            case 'accept_request':
                $this->acceptRequest();
                break;
            case 'reject_request':
                $this->rejectRequest();
                break;
        }
    }

    public function rejectRequest(){
        $receiver = $this->core->getUser();
        $incomming_username = $_POST['incomming_username'] ?? NULL;
        $incomming_user = $this->core->getDB()->getMeshupUser($incomming_username);
        $this->core->getDB()->removeFromConnectionQueue($incomming_user, $receiver);
    }

    public function acceptRequest(){
        $user = $this->core->getUser();
        $incomming_username = $_POST['incomming_username'] ?? NULL;
        $incomming_user = $this->core->getDB()->getMeshupUser($incomming_username);
        $this->tryConnect($user, $incomming_user);
    }

    /**
     * Get the status of connection requests, msgs, etc.
     */
    public function getStatus(){
        $user = $this->core->getUser();
        $user_id = $user->username;
        $new_requests = $this->core->getDB()->getNewConnectionRequests($user);
        $this->core->renderJSONSuccess($new_requests);
    }

    public function addToQueue(){
        $user1 = $this->core->getUser();
        $user2_username = $_POST['user_to_connect'] ?? NULL;
        $user2 = $this->core->getDB()->getMeshupUser($user2_username);
        $try_adding = $this->core->getDB()->addToConnectionQueue($user1, $user2);
        if($try_adding['status'] == true){
            $this->core->renderJSONSuccess($try_adding['msg']);
        } else {
            $this->core->renderJSONError($try_adding['msg']);
        }
    }
    
    private function tryConnect($user1, $user2){
        $data = [];
        if($user1 == NULL || $user2 == NULL){
            $data['msg'] = "User cannot be NULL";
            $this->core->renderJSONError($data);
        }
        $connection = $user1->connectTo($user2);
        if($connection['status']){
            $this->core->renderJSONSuccess($connection['msg']);
        } else {
            $this->core->renderJSONError($connection['msg']);
        }
    }
}
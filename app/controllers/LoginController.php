<?php

namespace app\controllers;

use app\library\Core;
use app\views\LoginView;
use app\views\AccountCreationView;

class LoginController {
    /** @var Core */
    protected $core;
    
    /** @var LoginView */
    protected $view;
    
    private $logged_in = false;

    public function __construct(Core $core) {
        $this->core = $core;
        // This is default. Should move view handling logic to an output class.
        $this->view = new LoginView();
    }

    public function run() {
        switch($_REQUEST['page']){
            case 'login':
            break;
            case 'check_login':
                $this->checkLogin();
            break;
            case 'new_account':
            // This handles the new account page
                $this->showNewAccountPage();
            break;
            case 'make_account':
            // This should be moved to authenticator class but is stuck here for now.
                $this->makeAccount();
            break;
            default:
                $this->showLoginPage();
                break;
        }
    }

    public function showNewAccountPage(){
        // TODO: Should move this to an authenticator class
        // TODO: Should move view handling logic to an output class.
        $this->view = new AccountCreationView;
        $this->core->renderOutput($this->view->showCreationPage());
    }

    public function checkLogin(){
        // TODO: Should move this to an authenticator class
        if($this->logged_in){
            // Needs cookies and whatever, saving for later.
            $this->login();
        }
        $error_flag = false;
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $username = $_POST["username"];
            if(empty(trim($username))){
                $username_err = "Please enter a username";
                $error_flag = true;
            }
            $password = $_POST["password"];
            if(empty(trim($password))){
                $password_err = "Please enter a password";
                $error_flag = true;
            }
        }

        if(!$this->core->getDB()->checkUser($username, $password)['status']){
            $error_flag = true;
        }

        if($error_flag){
            $this->core->redirect("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?&component=login');
        } else {
            $this->core->redirect("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?&component=main');
        }
        
    }

    public function makeAccount(){
        $error_flag = false;
        $username_err = "";
        $password_err = "";
        $name_err = "";
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $username = $_POST["username"];
            if(empty(trim($username))){
                $username_err = "Please enter a username";
                $error_flag = true;
            } else {
                if($this->core->getDB()->checkUserExist($username)){
                    $username_err = "Username is taken, please choose another";
                    $error_flag = true;
                }
            }
            $password = $_POST["password"];
            if(empty(trim($password))){
                // You can check here for password stuff
                $password_err = "Please enter a password";
                $error_flag = true;
            }
            $f_name = $_POST["first_name"];
            $l_name = $_POST["last_name"];
            if(empty(trim($f_name)) || empty(trim($l_name))){
                $name_err = "Name cannot be empty!";
                $error_flag = true;
            }
        }

        if($error_flag){
            $this->view = new AccountCreationView;
            $this->core->renderOutput($this->view->showCreationPage(array('username_err' => $username_err, 'password_err' => $password_err, 'name_err' => $name_err)));
        } else {
            // Yeh this system needs to be fixed...
            $this->core->getDB()->makeAccount(array($_POST["username"], $_POST["password"], $_POST["first_name"], $_POST["last_name"], $_POST["profession"]));
            $this->view = new LoginView();
            $this->core->renderOutput($this->view->showLoginPage(array('msg' => "Account created!")));
        }
    }

    public function showLoginPage() {
        // TODO: Should move view handling logic to an output class.
        $this->view = new LoginView();
        $this->core->renderOutput($this->view->showLoginPage());
    }
    
}
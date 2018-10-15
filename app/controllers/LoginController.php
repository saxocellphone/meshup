<?php

namespace app\controllers;

use app\library\Core;
use app\views\LoginView;

class LoginController {
    /** @var Core */
    protected $core;
    
    /** @var LoginView */
    protected $view;
    
    public function __construct(Core $core) {
        $this->core = $core;
        $this->view = new LoginView();
    }

    public function run() {
        $this->core->renderOutput($this->view->showLoginPage());
    }
    
}
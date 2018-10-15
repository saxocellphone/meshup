<?php

namespace app\controllers;

use app\library\Core;
use app\views\MainView;

class MainController {
    
    /** @var Core */
    protected $core;
    
    /** @var LoginView */
    protected $view;
    
    public function __construct(Core $core) {
        $this->core = $core;
        $this->view = new MainView();
    }

    public function run() {
        $this->core->renderOutput($this->view->showMainApp());
    }
    
}
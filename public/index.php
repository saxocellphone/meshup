<?php

/** Autoloading function */
spl_autoload_register(function ($class_name) {
    include '../' . str_replace("\\", "/", $class_name) . '.php';
});

use app\library\Core;
use app\controllers\LoginController;
use app\controllers\MainController;

$core = new Core();

$core->loadDatabase();

if (empty($_REQUEST['component'])) {
    $_REQUEST['component'] = 'login';
}

if (empty($_REQUEST['page'])) {
    $_REQUEST['page'] = 'login_page';
}

switch($_REQUEST['component']){
    case 'main':
        $control = new MainController($core);
        $control->run();
        break;
    case 'login':
        $control = new LoginController($core);
        $control->run();
        break;
    default:
        $control = new LoginController($core);
        $control->run();
        break;
}
$core->displayOutput();


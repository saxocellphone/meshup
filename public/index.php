<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/** Autoloading function */
spl_autoload_register(function ($class_name) {
    include __DIR__ . '/../' . str_replace("\\", "/", $class_name) . '.php';
});

use app\library\Core;
use app\controllers\LoginController;
use app\controllers\MainController;
use app\controllers\APIController;

define('TIMEZONE', 'America/New_York');
date_default_timezone_set(TIMEZONE);

session_start();
$_SESSION['logged_in'] = isset($_SESSION['logged_in']) ?? false;
$core = new Core();

$_SESSION['total_connection'] = isset($_SESSION['total_connection']) > 0 ? $_SESSION['total_connection'] : intval(0);

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
    case 'api':
        $control = new APIController($core);
        $control->run();
        break;
    default:
        $control = new LoginController($core);
        $control->run();
        break;
}
$core->displayOutput();


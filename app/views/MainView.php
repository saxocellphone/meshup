<?php

namespace app\views;

use app\library\Core;

class MainView {

    protected $core;
    /**
     * Shows the main app
     */
    public function __construct(Core $core) {
        $this->core = $core;
    }

    public function showMainApp($graph) {
        $site_url = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        $return = "";
        $return .= <<<HTML
            <html>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <body>
                <div class="icon-bar">
                    <a class="active" href="index.php?&component=main&page=user_setting"><i class="fa fa-cogs"></i></a> 
                    <a href="index.php?&component=login"><i class="fa fa-sign-out"></i></a>
                    <span id="welcome">Hello {$this->core->getUser()->first_name}!</span>

                </div>
                <div id="main"></div>
                <link rel="stylesheet" href="css/main.css">
                <!-- This script passes php variables to javascript -->
                <script>const site_url = '{$site_url}'; const adj_list = {$graph}; const self_username = '{$this->core->getUser()->username}'; let dragging_node = false;</script>
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.js"></script>
                <script src="vender/svg.draggable.min.js"></script>
                <script src="js/main.js" type="module"></script>
            </body>
            </html> 
HTML;
        return $return;
    }
}
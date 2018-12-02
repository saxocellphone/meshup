<?php

namespace app\views;

use app\library\Core;

class MainView {

    protected $core;

    public function __construct(Core $core) {
        $this->core = $core;
    }

    public function showMainApp($graph) {
        $site_url = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        $return = "";
        $return .= <<<HTML
        <!-- <a class="control" id="zoomout">Zoom Out</a>
        <a class="control" id="zoomin">Zoom In</a> -->
        <span id="welcome">Hello {$this->core->getUser()->first_name}!</span>
        <div id="main"></div>
        <link rel="stylesheet" href="css/main.css">
        <!-- This script passes php variables to javascript -->
        <script>const site_url = '{$site_url}'; const adj_list = {$graph}; const self_username = '{$this->core->getUser()->username}'</script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.js"></script>
        <script src="vender/svg.draggable.min.js"></script>
        <script src="js/main.js" type="module"></script>
HTML;
        return $return;
    }
}
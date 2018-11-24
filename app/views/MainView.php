<?php

namespace app\views;

class MainView {
    public function showMainApp($users, $username) {
        $return = "";
        $return .= <<<HTML
        <!-- <a class="control" id="zoomout">Zoom Out</a>
        <a class="control" id="zoomin">Zoom In</a> -->
        <span id="welcome">Hello {$username}!</span>
        <div id="main"></div>
        <link rel="stylesheet" href="css/main.css">
        <!-- This script passes php variables to javascript -->
        <script>let users = {$users}; let username = '{$username}'</script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.js"></script>
        <script src="vender/svg.draggable.min.js"></script>
        <script src="js/main.js" type="module"></script>
HTML;
        return $return;
    }
}
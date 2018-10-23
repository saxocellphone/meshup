<?php

namespace app\views;

class MainView {
    public function showMainApp() {
        $return = "";
        $return .= <<<HTML
        <!-- <p>This is the main page</p> -->
        <!-- <svg width="100%" height="100%" onload="start(evt)">   
            <circle class="draggable" cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
            <circle class="draggable" cx="150" cy="50" r="40" stroke="black" stroke-width="3" fill="blue" />
        </svg> -->
        <!-- <a class="control" id="zoomout">Zoom Out</a>
        <a class="control" id="zoomin">Zoom In</a> -->
        <div id="main"></div>
        <link rel="stylesheet" href="../../public/css/main.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.js"></script>
        <script src="../../public/vender/svg.draggable.min.js"></script>
        <script src="../../public/js/models/node.js" type="module"></script>
        <script src="../../public/js/models/connection.js" type="module"></script>
        <script src="../../public/js/main.js" type="module"></script>
HTML;
        return $return;
    }
}
<?php

namespace app\views;

class MainView {
    public function showMainApp($users, $username) {
        $site_url = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        $return = "";
        $return .= <<<HTML
        <!-- <a class="control" id="zoomout">Zoom Out</a>
        <a class="control" id="zoomin">Zoom In</a> -->
        <html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {margin:0;}

.icon-bar {
    width: 100%;
    background-color: tomato;
    overflow: auto;
}

.icon-bar a {
    float: left;
    width: 20%;
    text-align: center;
    padding: 12px 0;
    transition: all 0.3s ease;
    color: white;
    font-size: 36px;
}

.icon-bar a:hover {
    background-color: #000;
}

.active {
    background-color: #lightgray;
}
#welcome{
    color: white;
    margin: auto;
    font-size: 30;
    font-family: 'IBM Plex Sans', sans-serif;
    font-weight: bold;
}
</style>
<body>

<div class="icon-bar">
  <a class="active" href="#"><i class="fa fa-cogs"></i></a> 
  <a href="#"><i class="fa fa-sign-out"></i></a>
  <span id="welcome">Hello {$username}!</span>

</div>

</body>
</html> 

        
       
        <div id="main"></div>
        <link rel="stylesheet" href="css/main.css">
        <!-- This script passes php variables to javascript -->
        <script>const site_url = '{$site_url}'; const users = {$users}; const username = '{$username}'</script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/2.6.6/svg.js"></script>
        <script src="vender/svg.draggable.min.js"></script>
        <script src="js/main.js" type="module"></script>
HTML;
        return $return;
    }
}
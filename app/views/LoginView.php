<?php

namespace app\views;

class LoginView {
    public function showLoginPage() {
        $return = "";
        $return .= <<<HTML
        <link rel="stylesheet" href="css/login.css">
        <div id="particles-js"></div>
        <script src="vender/particles.js"></script>
        <script src="js/login.js"></script>
        <!-- <a href="index.php?&component=main">Goto main view</a> -->
        <form id="login" action="/index.php?&component=main">
            Username: <br>
            <input type="text" name="username"> <br>
            First name: <br> 
            <input type="text" name="first_name"> <br>
            Last name: <br>
            <input type="text" name="last_name"> <br>
            Profession: <br>
            <input type="text" name="profession"> <br>
            <input type="submit">
        </form>
HTML;
        return $return;
    }
}
<?php

namespace app\views;

class AccountCreationView {
    public function showCreationPage($msg = array()) {

        $username_err = $msg['username_err'] ?? "";
        $password_err = $msg['password_err'] ?? "";

        $return = "";
        $return .= <<<HTML
        <link rel="stylesheet" href="css/login.css">
        <div id="particles-js"></div>
        <script src="vender/particles.js"></script>
        <script src="js/login.js"></script>
        <form id="login" action="index.php?&component=login&page=make_account" method="post">
            New Username: <br>
            <input type="text" name="username"> {$username_err}<br> 
            New Password: <br>
            <input type="text" name="password"> {$password_err}<br>
            First name: <br> 
            <input type="text" name="first_name"> <br>
            Last name: <br>
            <input type="text" name="last_name"> <br>
            Profession: <br>
            <input type="text" name="profession"> <br>
            <input type="submit">
            <a href="index.php?&component=login">Login</a>
        </form>
HTML;
        return $return;
    }
}
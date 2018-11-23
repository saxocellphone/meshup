<?php

namespace app\views;

class LoginView {
    public function showLoginPage($msg = array()) {
        $msg = $msg['msg'] ?? "";

        $return = "";
        $return .= <<<HTML
        <link rel="stylesheet" href="css/login.css">
        <div id="particles-js"></div>
        <script src="vender/particles.js"></script>
        <script src="js/login.js"></script>
        <form id="login" action="index.php?&component=login&page=check_login" method="post">
            Username: <br>
            <input type="text" name="username"> <br>
            password: <br>
            <input type="text" name="password"> <br>
            {$msg}
            <input type="submit">
            <a href="index.php?&component=login&page=new_account">Create new account</a>
        </form>
HTML;
        return $return;
    }
}
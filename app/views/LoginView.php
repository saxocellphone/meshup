<?php

namespace app\views;

class LoginView {
    public function showLoginPage($msg = array()) {
        $msg = $msg['msg'] ?? "";
        $username_err = $msg['username_err'] ?? "";
        $password_err = $msg['password_err'] ?? "";
        $return = "";
        $return .= <<<HTML
        <!-- <link rel="stylesheet" href="css/login.css">
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
        </form> -->
        <!DOCTYPE html>
        <html lang="en" >

        <head>
            <meta charset="UTF-8">
            <title>MeshUp</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>
            <link rel='stylesheet' href="css/login.css">
        </head>
        <script src="vender/particles.js"></script>
        <script src="js/login.js"></script>

        <body>

        <div class="ct" id="t1">
        <div class="ct" id="t2">
        <div class="ct" id="t3">
                <ul id="menu">
                    <a href="#t1"><li class="icon fa fa-home" id="one"></li></a>
                    <a href="#t2"><li class="icon fa fa-sign-in" id="two"></li></a>
                    <a href="#t3"><li class="icon fa fa-user-plus" id="three"></li></a>

                </ul>
                <div id="particles-js"></div>
                <div class="page" id="p1">
                    <section class="icon"><img src="assets/MeshUp.png" alt="meshup logo" width="250px"><span class="hint"> MeshUp is a tool that allows you to visualize your social network</span></section>  
                </div>
                <div class="page" id="p2">
                    <section class="icon fa fa-sign-in"><span class="title">
                        <form id="login" action="index.php?&component=login&page=check_login" method="post">
                            Username: <br>
                            <input type="text" name="username"> <br>
                            password: <br>
                            <input type="text" name="password"> <br>
                            {$msg}
                            <input type="submit">
                        </form>
                    </span></section>
                </div>  
                <div class="page" id="p3">
                    <section class="icon fa fa-user-plus"><span class="title">
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
                    </span></section>
                </div>
                
                </div>
            </div>
            </div>
        </body>

        </html>
HTML;
        return $return;
    }
}
<?php

namespace app\views;

class LoginView {
    public function showLoginPage() {
        $return = "";
        $return .= <<<HTML
        <script src="../../public/js/login.js">
        </script>
        <a href="index.php?&component=main">hi</a>
HTML;
        return $return;
    }
}
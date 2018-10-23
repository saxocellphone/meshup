<?php

namespace app\views;

class LoginView {
    public function showLoginPage() {
        $return = "";
        $return .= <<<HTML
        <!-- <div id="particles-js"></div> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <script src="../../public/js/login.js"></script> -->
        <a href="index.php?&component=main">Goto main view</a>
HTML;
        return $return;
    }
}
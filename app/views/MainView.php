<?php

namespace app\views;

class MainView {
    public function showMainApp() {
        $return = "";
        $return .= <<<HTML
        <p>This is the main page</p>
HTML;
        return $return;
    }
}
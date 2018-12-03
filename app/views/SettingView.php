<?php

namespace app\views;

use app\library\Core;

class SettingView {
    protected $core;

    public function __construct(Core $core) {
        $this->core = $core;
    }

    public function showSettingView(){
        $return = "";
        $return .= <<<HTML
            <!doctype html>

            <html lang="en">
            <head>
            <meta charset="utf-8">

            <title>User Preferences</title>
            <link rel="stylesheet" href="css/user_settings.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            </head>
            <header>
                <h1>{$this->core->getUser()->username}</h1>
                <img src='https://avataaars.io/?avatarStyle=Circle&topType=ShortHairShortFlat&accessoriesType=Blank&hairColor=BrownDark&facialHairType=Blank&clotheType=Hoodie&clotheColor=Red&eyeType=EyeRoll&eyebrowType=UpDown&mouthType=Disbelief&skinColor=Pale'>
            </header>
            <body>
                <div id= main>
                    <h1> {$this->core->getUser()->first_name} {$this->core->getUser()->last_name}</h1>
                    <button>Change Nickname</button>
                    <button>Change Avatar</button>

                    <h2>Import Nodes From</h2>
                    <span class="fa-stack fa-3x">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-3x">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-3x">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="fa-stack fa-3x">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-address-book fa-stack-1x fa-inverse"></i>
                    </span>

                    <h2>Account Settings</h2>
                    <button>Change Password</button>
                </div>
            </body>
            <footer>
                <button>Return to Main View <i class="fa fa-sign-out"></i> </button>
            </footer>

HTML;
        return $return;
    }

}
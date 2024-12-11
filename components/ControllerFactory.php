<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerFactory
 *
 * @author morozovr
 */

namespace components;

use controllers\SettingsController;
use controllers\SignInController;
use controllers\LogoutController;
use controllers\SignUpController;
use controllers\NewPostController;
use controllers\UserController;
use controllers\UserReportController;
use controllers\IndexController;
use controllers\ShowPostController;
use controllers\EditPostController;
use controllers\ApplyUserController;
use controllers\NotFoundController;

class ControllerFactory {

    private $url;

    public function __construct($url) {
        $path = parse_url($url);
        $this->url = $path["path"];
    }

    public function getController() {
        switch ($this->url) {
            case '/settings': return new SettingsController();
            case '/signin': return new SignInController();
            case '/logout': return new LogoutController();
            case '/signup': return new SignUpController();
            case '/newpost': return new NewPostController();
            case '/user': return new UserController();
            case '/report': return new UserReportController();
            case '/home': return new IndexController();
            case '/': return new IndexController();
            case '/showpost': return new ShowPostController();
            case '/edit': return new EditPostController();
            case '/apply': return new ApplyUserController();
            default: return new NotFoundController();
                break;
        }
    }

}

?>

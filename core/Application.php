<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application
 *
 * @author morozovr
 */

namespace core;

use controllers\SettingsController;
use components\ControllerFactory;

class Application {

    //put your code here
    public function __construct() {
        $parameters = array('get' => $_GET, 'post' => $_POST);
        $ctrlfactory = new ControllerFactory($_SERVER['REQUEST_URI']);
        call_user_func(array($ctrlfactory->getController(), "render"), $parameters);
    }

}

?>

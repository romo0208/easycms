<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogoutController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;

class LogoutController extends GenericController {

    //put your code here
    public function performRequest($parameters) {
        $this->setAdapterMode(true);
        $this->logout();
        header("Location: home");
    }

    public static function logout() {
        unset($_SESSION['nickname']);
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 86400, '/');
        }
    }

}

?>

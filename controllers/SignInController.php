<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\UserModel;
use components\Utils;
use controllers\LogoutController;

class SignInController extends GenericController {

    public function __construct() {

        parent::__construct();
        $this->setSubViewPage("signin.php");
    }

    public function getTitle() {
        return Utils::getResource('RES_AUTHORISATION') . parent::getTitle();
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);

        if (isset($this->post['submit'])) {
            $login = $this->post['login'];
            $password = $this->post['password'];
            $success = false;
            if (empty($login)) {
                $result = Utils::getResource("RES_LOGIN_IS_EMPTY");
            } elseif (!preg_match("/[-a-zA-Zа-яА-Я0-9]{3,15}/", $login)) {
                $result = Utils::getResource("RES_LOGIN_IS_INCORRECT");
            } elseif (empty($password)) {
                $result = Utils::getResource("RES_PASSWORD_IS_EMPTY");
            } elseif (!preg_match("/[-a-zA-Z0-9]{3,30}/", $password)) {
                $result = Utils::getResource("RES_PASSWORD_IS_INCORRECT");
            } else {
                $password = Utils::cryptPassword($password);
                if (UserModel::singin($login, $password)) {
                    $model = new UserModel(UserModel::getUserIdByName($login));
                    if ($model->isConfirmed()) {
                        $this->startSession($login);
                        $result = Utils::getResource("RES_AUTH_SUCCESS");
                    } else {
                        LogoutController::logout();
                        Utils::sendRegistrationEmail($model);
                        $result = Utils::getResource("RES_ACCOUNT_IS_NOT_CONFIRMED");
                    }
                    $success = true;
                } else {
                    $result = Utils::getResource("RES_AUTH_FAILURE");
                }
            }
            $this->setValidationMessage($result);
            if ($success) {
                $this->setAdapterMode(true);
                Utils::redirect("home", $result);
            }
        }
    }

}

?>

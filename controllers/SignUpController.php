<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignUpController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\UserModel;
use components\Utils;

class SignUpController extends GenericController {

    //put your code here
    public function __construct() {

        parent::__construct();
        $this->setSubViewPage("signup.php");
    }

    public function getTitle() {
        return Utils::getResource('RES_REGISTRATION') . parent::getTitle();
    }

    public function performRequest($parameters) {

        parent::performRequest($parameters);

        if (isset($this->post['submit'])) {

            $login = $this->post['login'];
            $password = $this->post['password'];
            $password2 = $this->post['password2'];
            $email = $this->post['email'];

            $isLoginUnique = UserModel::checkLogin($login);
            $isEmailUnique = UserModel::checkEmail($email);

            $success = false;

            if (empty($login)) {
                $result = Utils::getResource("RES_LOGIN_IS_EMPTY");
            } elseif (!preg_match("/[-a-zA-Zа-яА-Я0-9]{3,15}/", $login)) {
                $result = Utils::getResource("RES_LOGIN_IS_INCORRECT");
            } elseif (empty($password)) {
                $result = Utils::getResource("RES_PASSWORD_IS_EMPTY");
            } elseif (!$isLoginUnique) {
                $result = Utils::getResource("RES_USER_ALREADY_EXISTS");
            } elseif (!$isEmailUnique) {
                $result = Utils::getResource("RES_EMAIL_ALREADY_EXISTS");
            } elseif (!preg_match("/[-a-zA-Z0-9]{3,30}/", $password)) {
                $result = Utils::getResource("RES_PASSWORD_IS_INCORRECT");
            } elseif (empty($password2)) {
                $result = Utils::getResource("RES_PASSWORD_CONFIRMATION_IS_EMPTY");
            } elseif (!preg_match("/[-a-zA-Z0-9]{3,30}/", $password2)) {
                $result = Utils::getResource("RES_PASSWORD_CONFIRMATION_IS_NOT_CORRECT");
            } elseif (strcmp($password, $password2) != 0) {
                $result = Utils::getResource("RES_PASSWORD_CONFIRMATION_IS_NOT_CORRECT");
            } elseif (empty($email)) {
                $result = Utils::getResource("RES_EMAIL_IS_EMPTY");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result = Utils::getResource("RES_EMAIL_IS_NOT_CORRECT");
            } else {
                $user = UserModel::signup($login, $password, $email);

                if ($user instanceof UserModel) {
                    $success = true;
                    //$this->startSession($login);
                    Utils::sendRegistrationEmail($user);
                    $result = Utils::getResource("RES_SIGNUP_SUCCESS");
                } else {
                    $result = Utils::getResource("RES_UNEXPECTED_ERROR");
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

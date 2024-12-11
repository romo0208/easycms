<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\UserModel;
use components\Utils;

class UserController extends GenericController {

    private $id;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->setOnlyAuthorizedAccess(true);
        $this->setSubViewPage("user.php");
        $this->id = $_GET['id'];
        if (!empty($this->id)) {
            $this->userModel = new UserModel($this->id);            
        } else {
            $this->userModel = $this->getLoggedInUserModel();
        }
        if (!$this->userModel->isInitialized()) {
            Utils::redirect("404");
        }
    }

    public function getTitle() {
        return Utils::getResource('RES_PROFILE') . parent::getTitle();
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {

            $password2 = $this->post['password2'];
            $password3 = $this->post['password3'];
            $user_group = $this->post['user_group'];
            $success = false;
            if (!empty($password2)) {
                if (!preg_match("/[-a-zA-Z0-9]{3,30}/", $password2)) {
                    $result = Utils::getResource("RES_PASSWORD_IS_INCORRECT");
                } elseif (!preg_match("/[-a-zA-Z0-9]{3,30}/", $password3)) {
                    $result = Utils::getResource("RES_PASSWORD_CONFIRMATION_IS_NOT_CORRECT");
                } elseif (!strcmp($password2, $password3) == 0) {
                    $result = Utils::getResource("RES_PASSWORDS_DONT_MATCH");
                } else {
                    $this->userModel->changePassword($password2);
                    $success = true;
                }
            } else {
                $success = true;
            }
            if ($success) {
                $this->setValidationMessage("Пользователь успешно обновлен!");
                $this->userModel->setAdmin(strcmp($user_group, 1) == 0);
            } else {
                $this->setValidationMessage($result);
            }
        }
    }

    public function getLogin() {
        return $this->userModel->getLogin();
    }

    public function getRegistrationDate() {
        return $this->userModel->getRegistrationDate();
    }

    public function isAdmin() {
        return $this->userModel->isAdmin();
    }

    public function getIPAddress() {
        return $this->userModel->getIPAddress();
    }

    public function getEmail() {
        return $this->userModel->getEmail();
    }

}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserReportController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\UserModel;
use components\Utils;
use controllers\LogoutController;

class UserReportController extends GenericController {

    public function __construct() {

        parent::__construct();
        $this->setOnlyAdminAccess(true);
        $this->setSubViewPage("report.php");
    }

    public function getTitle() {
        return Utils::getResource('RES_REPORT') . parent::getTitle();
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {
            $data = $this->post['checkbox'];
            if (isset($data)) {
                foreach ($data as $userId) {
                    $model = new UserModel($userId);
                    if (strcmp($this->getUserId(), $userId) == 0) {
                        LogoutController::logout();
                    }
                    $model->delete();
                }
                $this->setValidationMessage(Utils::getResource("RES_USERS_HAVE_BEEN_DELETED"));
            } else {
                $this->setValidationMessage(Utils::getResource("RES_PLEASE_SELECT_USERS"));
            }
        }
    }

    public function getAllUsers() {
        return UserModel::getAllUsers();
    }

}

?>

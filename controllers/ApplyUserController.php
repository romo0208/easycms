<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplyUserController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use components\Utils;
use models\UserModel;

class ApplyUserController extends GenericController {

    public function __construct() {

        parent::__construct();
        $this->setAdapterMode(true);
        $user = $_GET['user'];
        $pending_id = $_GET['pending'];
        if (empty($user) || empty($pending_id)) {
            Utils::redirect("home");
        }

        $model = new UserModel($user);

        if ($model->isConfirmed()) {
            $result = $model->getLogin() . Utils::getResource("RES_EMAIL_HAS_BEEN_ALREADY_CONFIRMED");
        } else {
            if (strcmp($model->getPendingId(), $pending_id) == 0) {
                $model->markConfirmed();
                $result = Utils::getResource("RES_EMAIL_HAS_BEEN_CONFIRMED");
                $this->startSession($model->getLogin());
            } else {
                $result = Utils::getResource("RES_UNEXPECTED_ERROR");
            }
        }
        Utils::redirect("home", $result);
    }

}

?>

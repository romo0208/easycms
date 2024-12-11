<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controllers;

use models\SettingsModel;
use models\UserModel;
use components\Utils;

/**
 * Description of GenericController
 *
 * @author morozovr
 */
class GenericController {

    //put your code here
    protected $validationMessage;
    protected $subViewPage;
    private $isAdapterMode = false;
    private $isOnlyAdminAccess = false;
    private $isOnlyAuthorizedAccess = false;
    protected $get;
    protected $post;

    public function __construct() {
        session_start();
    }

    function render($parameters = NULL) {
        if (isset($parameters)) {
            $this->performRequest($parameters);
        }
        $this->checkAccess();
        if (!$this->isAdapterMode) {
            $controller = $this;
            ob_start();
            require $_SERVER['DOCUMENT_ROOT'] . '/views/generic.php';
            ob_end_flush();
        }
    }

    private function checkAccess() {
        $model = new UserModel($this->getUserId());
        if ($this->isOnlyAdminAccess) {
            if (!$model->isAdmin()) {
                Utils::redirect("signin", Utils::getResource("RES_ADMIN_RESTICTED_ACCESS"));
            }
        }
        if ($this->isOnlyAuthorizedAccess) {

            if (!$this->isAuthorized()) {
                Utils::redirect("signin", Utils::getResource("RES_AUTH_IS_REQUIRED"));
            }
        }
    }

    function performRequest($parameters) {
        $this->get = $parameters['get'];
        $this->post = $parameters['post'];
    }

    public function getUserName() {
        $user = $_SESSION['nickname'];
        if (!isset($user)) {
            return Utils::getResource("RES_GUEST");
        } else {
            return $user;
        }
    }

    public function getUserId() {
        return UserModel::getUserIdByName($this->getUserName());
    }

    public function isAuthorized() {
        $nick = $_SESSION['nickname'];
        $resource = Utils::getResource("RES_GUEST");
        return !empty($nick) && !(strcmp($nick, $resource) == 0);
    }

    public function startSession($login) {
        $_SESSION['nickname'] = $login;
    }

    protected function setAdapterMode($mode) {
        $this->isAdapterMode = $mode;
    }

    protected function isAdapterMode() {
        return $this->isAdapterMode;
    }

    public function setSubViewPage($page) {
        $this->subViewPage = $page;
    }

    public function getSubViewPage() {
        return $this->subViewPage;
    }

    public function getValidationMessage() {
        $msg = $this->validationMessage;
        return empty($msg) ? $this->get['result'] : $msg;
    }

    public function setValidationMessage($message) {
        return $this->validationMessage = $message;
    }

    public function setOnlyAdminAccess($flag) {
        $this->isOnlyAdminAccess = $flag;
    }

    public function setOnlyAuthorizedAccess($flag) {
        $this->isOnlyAuthorizedAccess = $flag;
    }

    public static function getMainListData() {
        return SettingsModel::getMainListData();
    }

    public function getTitle() {
        return htmlspecialchars(stripslashes(SettingsModel::getProperty("easycms.sitename")));
    }

    public function getKeywords() {
        return htmlspecialchars(stripslashes(SettingsModel::getProperty("easycms.keywords")));
    }

    public function getDomain() {
        return SettingsModel::getProperty("easycms.domain");
    }

    public function getMetricID() {
        return SettingsModel::getProperty("easycms.metric");
    }

    public function getYear() {
        return date("Y");
    }

    protected function getLoggedInUserModel() {
        return new UserModel(UserModel::getUserIdByName($this->getUserName()));
    }

    public function isLoggedInUserAdmin() {
        return $this->getLoggedInUserModel()->isAdmin();
    }

}

?>

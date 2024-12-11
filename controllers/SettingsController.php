<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingsController
 *
 * @author MorozovR
 */

namespace controllers;

use controllers\GenericController;
use components\FileUploader;
use models\SettingsModel;
use components\Utils;

class SettingsController extends GenericController {

//put your code here


    public function __construct() {

        parent::__construct();
        $this->setOnlyAdminAccess(true);
        $this->setSubViewPage("settings.php");
    }

    public function getKeywords() {
        return SettingsModel::getProperty("easycms.keywords");
    }

    public function getPostsOnPage() {
        return SettingsModel::getProperty("easycms.postsonpage");
    }

    public function areUserPostsOn() {
        $data = SettingsModel::getProperty("easycms.userpostson");
        return (strcmp($data, 'true') == 0);
    }

    public function getAdminEmail() {
        return SettingsModel::getProperty("easycms.adminemail");
    }

    public function performRequest($parameters) {        
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {

            $sitename = $this->post['sitename'];
            $domain = $this->post['domain'];
            $keywords = $this->post['keywords'];
            $postsonpage = $this->post['postsonpage'];
            $userpostson = isset($this->post['userpostson']) ? "true" : "false";
            $adminemail = $this->post['adminemail'];
            $metric = $this->post['metric'];

            $success = false;

            if (empty($sitename)) {
                $message = Utils::getResource("RES_SITENAME_IS_EMPTY");
            } elseif (!filter_var($domain, FILTER_VALIDATE_URL)) {
                $message = Utils::getResource("RES_DOMAIN_IS_NOT_CORRECT");
            } elseif (!filter_var($adminemail, FILTER_VALIDATE_EMAIL)) {
                $message = Utils::getResource("RES_ADMIN_EMAIL_IS_NOT_CORRECT");
            } elseif (!is_numeric($postsonpage)) {
                $message = Utils::getResource("RES_POSTS_ON_PAGE_VALUE_IS_NOT_CORRECT");
            } elseif (!empty($metric) && !is_numeric($metric)) {
                $message = Utils::getResource("RES_YANDEX_METRICA_IS_NOT_CORRECT");
            } else {
                $success = true;
            }

            if ($success && !(($_FILES['picture'] == "none") || (empty($_FILES['picture']['name'])))) {
                $fileUploader = new FileUploader($_FILES['picture'], SettingsModel::getProperty('easycms.header'));
                $fileUploader->upload();
                if ($fileUploader->isSuccessful()) {
                    SettingsModel::setProperty('easycms.header', $fileUploader->getUploadedFilename());
                } else {
                    $message = $fileUploader->getMessage();
                    $success = false;
                }
            }
            if ($success) {
                SettingsModel::setProperty('easycms.sitename', $sitename);
                SettingsModel::setProperty('easycms.domain', $domain);
                SettingsModel::setProperty('easycms.keywords', $keywords);
                SettingsModel::setProperty('easycms.postsonpage', $postsonpage);
                SettingsModel::setProperty('easycms.userpostson', $userpostson);
                SettingsModel::setProperty('easycms.adminemail', $adminemail);
                SettingsModel::setProperty('easycms.metric', $metric);
                $message = Utils::getResource("RES_SETTINGS_APPLIED");
            }
            $this->setValidationMessage($message);
        }
    }

}

?>

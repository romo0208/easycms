<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewPostController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\PostModel;
use components\Utils;
use components\FileUploader;
use models\SettingsModel;

class NewPostController extends GenericController {

    public function __construct() {

        parent::__construct();
        if (strcmp(SettingsModel::getProperty("easycms.userpostson"), "true") == 0) {
            $this->setOnlyAdminAccess(true);
        } else {
            $this->setOnlyAuthorizedAccess(true);
        }
        $this->setSubViewPage("newpost.php");
    }

    public function getTitle() {
        return Utils::getResource('RES_NEW_POST') . parent::getTitle();
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {
            $caption = $this->post['caption'];
            $body = $this->post['body'];
            $picture = $this->post['picture'];
            $video = $this->post['video'];
            $user_id = $this->getUserId();
            $success = false;

            if (empty($caption)) {
                $result = Utils::getResource("RES_ENTER_CAPTION");
            } elseif (empty($body)) {
                $result = Utils::getResource("RES_ENTER_BODY");
            } elseif (empty($_FILES["picture"]["name"])) {
                $result = Utils::getResource("RES_ENTER_PICTURE");
            } else {
                $fileUploader = new FileUploader($_FILES['picture']);
                $fileUploader->upload();
                if ($fileUploader->isSuccessful()) {
                    $picture = $fileUploader->getUploadedFilename();
                    PostModel::add($caption, $body, $picture, $video, $user_id);
                    $result = Utils::getResource("RES_POST_IS_ADDED");
                    $success = true;
                } else {
                    $result = $fileUploader->getMessage();
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

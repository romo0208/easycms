<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditPostController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\PostModel;
use components\Utils;
use components\FileUploader;

class EditPostController extends GenericController {

    private $id;
    private $model;

    public function __construct() {
        parent::__construct();
        $this->setOnlyAdminAccess(true);
        $this->setSubViewPage("edit.php");
        $this->id = $_GET['id'];
        $this->model = new PostModel($this->id);
        if (!$this->model->isInitialized()) {
            Utils::redirect("404");
        }
    }

    public function getCaption() {
        return $this->model->getCaption();
    }

    public function getBody() {
        return $this->model->getBody();
    }

    public function getVideo() {
        return $this->model->getVideo();
    }

    private function getPicture() {
        return $this->model->getPicture();
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {
            $caption = $this->post['caption'];
            $body = $this->post['body'];
            $picture = $this->post['picture'];
            $video = $this->post['video'];
            $page = $this->get['page'];
            $success = false;

            if (empty($caption)) {
                $result = Utils::getResource("RES_ENTER_CAPTION");
            } elseif (empty($body)) {
                $result = Utils::getResource("RES_ENTER_BODY");
            } elseif (!empty($_FILES["picture"]["name"])) {
                $fileUploader = new FileUploader($_FILES['picture'], $this->getPicture());
                $fileUploader->upload();
                if ($fileUploader->isSuccessful()) {
                    $picture = $fileUploader->getUploadedFilename();
                    $this->model->setPicture($picture);
                    $success = true;
                    $result = Utils::getResource("RES_POST_HAS_BEEN_UPDATED");
                } else {
                    $success = false;
                    $result = $fileUploader->getMessage();
                }
            } else {
                $success = true;
                $result = Utils::getResource("RES_POST_HAS_BEEN_UPDATED");
            }

            $this->setValidationMessage($result);
            if ($success) {
                $this->model->setCaption($caption);
                $this->model->setBody($body);
                $this->model->setVideo($video);
                $this->setAdapterMode(true);
                Utils::redirect("home?page=" . $page . '&result=' . $result);
            }
        }
    }

}

?>

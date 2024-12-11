<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShowPostController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\PostModel;
use models\UserModel;
use models\CommentModel;
use components\Utils;

class ShowPostController extends GenericController {

    private $id;
    private $model;

    public function __construct() {

        parent::__construct();
        $this->setSubViewPage("showpost.php");
        $this->id = $_GET['id'];
        $this->model = new PostModel($this->id);
        if (!$this->model->isInitialized()) {
            Utils::redirect("404");
        }
    }

    public function getId() {
        return $this->model->getId();
    }

    public function getCaption() {
        return $this->model->getCaption();
    }

    public function getBody() {
        return $this->model->getBody();
    }

    public function getPicture() {
        return $this->model->getPicture();
    }

    public function getVideoFrame() {
        return $this->model->getVideoFrame();
    }

    public function getUser() {
        return $this->model->getUser();
    }

    public function getDate() {
        return $this->model->getDate();
    }

    public function getAllComments() {
        return $this->model->getAllComments();
    }

    public function getTitle() {
        return $this->model->getCaption();
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {
            $mode = $this->post['mode'];

            if (strcmp($mode, 'addcomment') == 0) {
                $comment = $this->post['comment'];
                $user_id = $this->getUserId();
                $post_id = $this->getId();

                if (empty($comment)) {
                    $this->setValidationMessage(Utils::getResource("RES_COMMENT_COULD_NOT_BE_EMPTY"));
                } else {
                    CommentModel::add($user_id, $post_id, $comment);
                    Utils::sendCommentNotification(new UserModel($user_id), new PostModel($post_id), $comment);
                    $this->setValidationMessage(Utils::getResource("RES_COMMENT_HAS_BEEN_ADDED"));
                }
            } elseif (strcmp($mode, 'deletecomments') == 0) {
                $data = $this->post['checkbox'];
                if (isset($data)) {
                    foreach ($data as $commentId) {
                        $model = new CommentModel($commentId);
                        $model->delete();
                    }
                    $this->setValidationMessage(Utils::getResource("RES_COMMENTS_HAVE_BEEN_DELETED"));
                } else {
                    $this->setValidationMessage(Utils::getResource("RES_PLEASE_SELECT_COMMENTS"));
                }
            }
        }
    }

}

?>

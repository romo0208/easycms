<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use models\PostModel;
use components\Utils;
use models\SettingsModel;

class IndexController extends GenericController {

    private $page;
    private $search;
    private $data;
    private $data2;
    private static $PAGINATOR_WINDOW = 10;

    //put your code here
    public function __construct() {

        parent::__construct();
        $this->setSubViewPage("home.php");
        $this->page = $_POST["page"];
        if (empty($this->page)) {
            $this->page = $_GET["page"];
        }
        $this->search = $_POST["search"];
        if (empty($this->search)) {
            $this->search = $_GET["search"];
        }
        $this->data = PostModel::getAllPosts($this->search, $this->getPage());
        $this->data2 = PostModel::getAllPosts($this->search);
    }

    public function performRequest($parameters) {
        parent::performRequest($parameters);
        if (isset($this->post['submit'])) {
            $post_id = $this->post['post_id'];
            $action = $this->post['actions'];
            if (strcmp($action, "none") == 0) {
                $this->setValidationMessage(Utils::getResource("RES_CHOOSE_ACTION"));
            } elseif (strcmp($action, "edit") == 0) {
                Utils::redirect("edit?id=" . $post_id . "&page=" . $this->getPage());
                exit();
            } elseif (strcmp($action, "delete") == 0) {
                $model = new PostModel($post_id);
                $model->delete();
                $this->setValidationMessage(Utils::getResource("RES_POST_HAS_BEEN_DELETED"));
            } elseif (strcmp($action, "add_to_menu") == 0) {
                $model = new PostModel($post_id);
                $model->markAsMain(true);
                $this->setValidationMessage(Utils::getResource("RES_POST_HAS_BEEN_ADDED_TO_MENU"));
            } elseif (strcmp($action, "delete_from_menu") == 0) {
                $model = new PostModel($post_id);
                $model->markAsMain(false);
                $this->setValidationMessage(Utils::getResource("RES_POST_HAS_BEEN_DELETED_FROM_MENU"));
            }
            $message = $this->getValidationMessage();
            if (!empty($this->search)) {
                Utils::redirect("home?page=" . $this->getPage() . "&search=" . $this->search);
            } elseif (!empty($message)) {
                Utils::redirect("home?page=" . $this->getPage() . "&result=" . $this->getValidationMessage());
            } else {
                Utils::redirect("home?page=" . $this->getPage());
            }
        }
    }

    public function getTitle() {
        return Utils::getResource('RES_MAIN_PAGE') . parent::getTitle();
    }

    public function getAllPosts() {
        return $this->data;
    }

    public function getPage() {
        return empty($this->page) ? 1 : $this->page;
    }

    public function getSearch() {
        return $this->search;
    }

    public function getPageCount() {
        $postsCount = count($this->data2, COUNT_NORMAL);
        $postsOnPage = SettingsModel::getProperty('easycms.postsonpage');
        if ($postsCount == 0) {
            return 1;
        } else {
            $division = $postsCount / $postsOnPage;
            $floor = floor($division);
            $reminder = $division - floor($division);

            if (!$reminder > 0) {
                return $floor;
            } else {
                return $floor + 1;
            }
        }
    }

    public function getMinimumPaginatorValue() {
        $page = $this->getPage();
        $pageCount = $this->getPageCount();
        if ($page > $pageCount) {
            $page = $pageCount;
        }
        if ($page < static::$PAGINATOR_WINDOW) {
            return 1;
        } else {
            return $page - (intval(static::$PAGINATOR_WINDOW / 2));
        }
    }

    public function getMaximumPaginatorValue() {
        $pageCount = $this->getPageCount();
        $minimumValue = $this->getMinimumPaginatorValue();
        $maximumValue = $minimumValue + static::$PAGINATOR_WINDOW - 1;
        if ($maximumValue > $pageCount) {
            return $pageCount;
        }
        return $maximumValue;
    }

    public function getLogo() {
        return SettingsModel::getProperty("easycms.header");
    }

}

?>

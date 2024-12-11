<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostModel
 *
 * @author morozovr
 */

namespace models;

use components\MySQL;
use components\Utils;
use models\Model;
use models\SettingsModel;

class PostModel extends Model {

    //put your code here
    private $post_id;
    private $caption;
    private $body;
    private $picture;
    private $video;
    private $is_main;
    private $user_id;
    private $date;

    public function __construct($id) {
        parent:: __construct();

        $params = array('i', &$id);
        $this->dbStart();
        $data = $this->mysql->executeSelect(Utils::getQuery("QUERY_GET_POST_BY_ID"), $params);
        if (sizeof($data) == 0) {
            $this->markInitialized(false);
        }

        foreach ($data as $row) {
            $this->post_id = $row['post_id'];
            $this->caption = $row['caption'];
            $this->body = $row['body'];
            $this->picture = $row['picture'];
            $this->video = $row['video'];
            $this->is_main = $row['is_main'];
            $this->user_id = $row['user_id'];
            $this->date = $row['date'];
        }
        $this->dbStop();
    }

    public function getId() {
        return $this->post_id;
    }

    public function getCaption() {
        return nl2br(stripslashes($this->caption));
    }

    public function setCaption($caption) {
        $params = array('si', &$caption, &$this->post_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_SET_CAPTION"), $params);
        $this->dbStop();
        $this->caption = $caption;
    }

    public function getBody() {
        return stripslashes($this->body);
    }

    public function getBodyAnnouncement() {
        return trim(mb_substr(strip_tags($this->body), 0, 200, 'UTF-8')) . "...";
    }

    public function setBody($body) {
        $params = array('si', &$body, &$this->post_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_SET_BODY"), $params);
        $this->dbStop();
        $this->body = $body;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function setPicture($picture) {
        $params = array('si', &$picture, &$this->post_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_SET_PICTURE"), $params);
        $this->dbStop();
        $this->picture = $picture;
    }

    public function getVideoFrame() {
        $video = str_replace("https://", "", $this->video);
        $video = str_replace("http://", "", $video);
        $video = str_replace("watch?v=", "embed/", $video);
        return $video;
    }

    public function getVideo() {

        return $this->video;
    }

    public function setVideo($video) {
        $params = array('si', &$video, &$this->post_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_SET_VIDEO"), $params);
        $this->dbStop();
        $this->video = $video;
    }

    public function isMain() {
        return ($this->is_main == 1);
    }

    public function markAsMain($is_main) {
        $main_flag = $is_main ? 1 : 0;
        $params = array('ii', &$main_flag, &$this->post_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_MAIN"), $params);
        $this->dbStop();
        $this->is_main = $main_flag;
    }

    public function getUser() {
        return new UserModel($this->user_id);
    }

    public function getDate() {
        $dt = new \DateTime($this->date);
        return $dt->format("d.m.Y G:i:s");
    }

    public static function add($caption, $body, $picture, $video, $user_id) {
        self::$mysql = new MySQL();
        $params = array('ssssi', &$caption, &$body, &$picture, &$video, &$user_id);
        self::$mysql->executeUpdate(Utils::getQuery("QUERY_CREATE_POST"), $params);
        $id = self::$mysql->selectForValueOrNull(Utils::getQuery("QUERY_GET_ID"), 'VALUE');
        self::$mysql->close();
        return new PostModel($id);
    }

    public function delete() {
        $params = array('i', &$this->post_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_DELETE_POST"), $params);
        $this->dbStop();
        unlink($this->getPicture());
    }

    public static function getAllPosts($search, $page = NULL) {

        $search = '%' . $search . '%';
        if (isset($page)) {
            $limit = SettingsModel::getProperty("easycms.postsonpage");
            self::$mysql = new MySQL();
            $offset = $limit * intval($page) - $limit;
            $params = array('sssssii', &$search, &$search, &$search, &$search, &$search, &$offset, &$limit);
            $data = self::$mysql->executeSelect(Utils::getQuery("QUERY_GET_ALL_POSTS"), $params);
        } else {
            self::$mysql = new MySQL();
            $params = array('sssss', &$search, &$search, &$search, &$search, &$search);
            $data = self::$mysql->executeSelect(Utils::getQuery("QUERY_GET_ALL_POSTS2"), $params);
        }
        $array = array();
        foreach ($data as $row) {
            array_push($array, new PostModel($row["post_id"]));
        }
        self::$mysql->close();
        return $array;
    }

    public function getAllComments() {
        self::$mysql = new MySQL();
        $params = array('i', &$this->post_id);
        $data = self::$mysql->executeSelect(Utils::getQuery("QUERY_GET_ALL_COMMENTS"), $params);
        $array = array();
        foreach ($data as $row) {
            array_push($array, new CommentModel($row["comment_id"]));
        }
        self::$mysql->close();
        return $array;
    }

    public function getMenuOption() {
        $res_id = $this->isMain() ? 'RES_REMOVE_FROM_MENU' : 'RES_ADD_TO_MENU';
        return Utils::getResource($res_id);
    }

    public function getMenuAction() {
        return $this->isMain() ? "delete_from_menu" : "add_to_menu";
    }

    public function getActionListId() {
        return "actionlist" . $this->getId();
    }

}

?>

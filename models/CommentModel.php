<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentModel
 *
 * @author morozovr
 */

namespace models;

use models\Model;
use models\UserModel;
use models\PostModel;
use components\Utils;
use components\MySQL;

class CommentModel extends Model {

    //put your code here
    private $comment_id;
    private $user_id;
    private $post_id;
    private $comment;
    private $date;

    public function __construct($id) {
        parent:: __construct();

        $params = array('i', &$id);
        $this->dbStart();
        $data = $this->mysql->executeSelect(Utils::getQuery("QUERY_GET_COMMENT_BY_ID"), $params);
        foreach ($data as $row) {
            $this->comment_id = $row['comment_id'];
            $this->user_id = $row['user_id'];
            $this->post_id = $row['post_id'];
            $this->comment = $row['comment'];
            $this->date = $row['date'];
        }
        $this->dbStop();
    }

    public function getId() {
        return $this->comment_id;
    }

    public function getUser() {
        return new UserModel($this->user_id);
    }

    public function getPost() {
        return new PostModel($this->post_id);
    }

    public function getComment() {
        return nl2br(htmlspecialchars(stripslashes($this->comment)));
    }

    public function getDate() {
        $dt = new \DateTime($this->date);
        return $dt->format("d.m.Y G:i:s");
    }

    public static function add($user_id, $post_id, $comment) {
        self::$mysql = new MySQL();
        $params = array('iis', &$user_id, &$post_id, &$comment);
        self::$mysql->executeUpdate(Utils::getQuery('QUERY_CREATE_COMMENT'), $params);
        $id = self::$mysql->selectForValueOrNull(Utils::getQuery('QUERY_GET_ID'), 'VALUE');
        self::$mysql->close();
        return new CommentModel($id);
    }

    public function delete() {
        $params = array('i', &$this->comment_id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery('QUERY_DELETE_COMMENT'), $params);
        $this->dbStop();
    }

}

?>

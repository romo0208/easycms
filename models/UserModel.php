<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModel
 *
 * @author morozovr
 */

namespace models;

use components\MySQL;
use components\Utils;
use models\Model;
use models\CommentModel;

class UserModel extends Model {

    //put your code here
    private $id;
    private $login;
    private $password;
    private $email;
    private $registration_date;
    private $pending_id;
    private $is_admin;
    private $ip_address;

    public function __construct($id) {
        parent:: __construct();

        $params = array('i', &$id);
        $this->dbStart();
        $data = $this->mysql->executeSelect(Utils::getQuery("QUERY_GET_USER_BY_ID"), $params);
        if (sizeof($data) == 0) {
            $this->markInitialized(false);
        }
        foreach ($data as $row) {
            $this->id = $row['user_id'];
            $this->login = $row['login'];
            $this->password = $row['password'];
            $this->email = $row['email'];
            $this->registration_date = $row['registration_date'];
            $this->pending_id = $row['pending_id'];
            $this->is_admin = $row['is_admin'];
            $this->ip_address = $row['ip_address'];
        }
        $this->dbStop();
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRegistrationDate() {
        $dt = new \DateTime($this->registration_date);
        return $dt->format("d.m.Y G:i:s");
    }

    public function getPendingId() {
        return $this->pending_id;
    }

    public function isAdmin() {
        return (strcmp($this->is_admin, '1') == 0);
    }

    public function getIPAddress() {
        return $this->ip_address;
    }

    public function setAdmin($isadmin) {
        $admin_flag = $isadmin ? 1 : 0;
        $params = array('ii', &$admin_flag, &$this->id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_ADMIN"), $params);
        $this->dbStop();
        $this->is_admin = $admin_flag;
    }

    public function markConfirmed() {
        $params = array('i', &$this->id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_MARK_CONFIRMED"), $params);
        $this->dbStop();
        $this->pending_id = "";
    }

    public function isConfirmed() {
        $params = array('i', &$this->id);
        $this->dbStart();
        $result = $this->mysql->selectForRuwnum(Utils::getQuery("QUERY_IS_CONFIRMED"), $params);
        $this->dbStop();
        return (strcmp($result, 1) == 0);
    }

    public function changePassword($newpassword) {
        $password = Utils::cryptPassword($newpassword);
        $params = array('si', &$password, &$this->id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_SET_PASSWORD"), $params);
        $this->dbStop();
        $this->password = $password;
    }

    public function delete() {
        $params = array('i', &$this->id);
        $this->dbStart();
        $this->mysql->executeUpdate(Utils::getQuery("QUERY_DELETE_USER"), $params);
        $this->dbStop();
    }

    public static function singin($login, $password) {
        $params = array('ss', &$login, &$password);
        self::$mysql = new MySQL();
        $result = self::$mysql->selectForRuwnum(Utils::getQuery("QUERY_CHEK_USER_EXISTENCE_BY_CREDENTIALS"), $params);
        self::$mysql->close();
        return ($result > 0);
    }

    public static function signup($login, $password, $email) {
        self::$mysql = new MySQL();
        $pending_id = Utils::getUniqueID();
        $password = Utils::cryptPassword($password);
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $params = array('sssss', &$login, &$password, &$email, &$pending_id, &$ipaddress);
        self::$mysql->executeUpdate(Utils::getQuery("QUERY_CREATE_USER"), $params);
        $id = self::$mysql->selectForValueOrNull(Utils::getQuery("QUERY_GET_ID"), 'VALUE');
        self::$mysql->close();
        return new UserModel($id);
    }

    public static function checkEmail($email) {
        self::$mysql = new MySQL();
        $params = array('s', &$email);
        $result = self::$mysql->selectForRuwnum(Utils::getQuery("QUERY_CHECK_EMAIL"), $params);
        self::$mysql->close();
        return !($result > 0);
    }

    public static function checkLogin($login) {
        self::$mysql = new MySQL();
        $params = array('s', &$login);
        $result = self::$mysql->selectForRuwnum(Utils::getQuery("QUERY_CHECK_LOGIN"), $params);
        self::$mysql->close();
        return !($result > 0);
    }

    public static function getUserIdByName($login) {
        self::$mysql = new MySQL();
        $params = array('s', &$login);
        $result = self::$mysql->selectForValueOrNull(Utils::getQuery("QUERY_GET_USER_ID_BY_LOGIN"), 'user_id', $params);
        self::$mysql->close();
        return $result;
    }

    public static function getUserNameById($id) {
        self::$mysql = new MySQL();
        $params = array('i', &$id);
        $result = self::$mysql->selectForValueOrNull(Utils::getQuery("QUERY_GET_USER_NAME_BY_ID"), 'login', $params);
        self::$mysql->close();
        return $result;
    }

    public static function getAllUsers() {
        self::$mysql = new MySQL();
        $data = self::$mysql->executeSelect(Utils::getQuery("QUERY_GET_ALL_USERS"));
        $array = array();
        foreach ($data as $row) {
            array_push($array, new UserModel($row["user_id"]));
        }
        self::$mysql->close();
        return $array;
    }

}

?>

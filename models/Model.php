<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author morozovr
 */

namespace models;

use components\MySQL;
use components\Utils;

class Model {

    protected static $mysql;
    protected $isInitialized = false;

    //put your code here

    public function __construct() {
        $this->isInitialized = true;
    }

    public function dbStart() {
        $this->mysql = new MySQL();
    }

    public function dbStop() {
        $this->mysql->close();
    }

    public function isInitialized() {
        return $this->isInitialized;
    }

    public function markInitialized($flag) {
        $this->isInitialized = $flag;
    }

    public static function getMainListData() {
        self::$mysql = new MySQL();
        $result = self::$mysql->executeSelect(Utils::getQuery("QUERY_MAINLIST"));
        self::$mysql->close();
        return $result;
    }

}

?>

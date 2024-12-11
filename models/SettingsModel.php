<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

use models\Model;
use components\MySQL;
use components\Utils;

/**
 * Description of SettingsModel
 *
 * @author morozovr
 */
class SettingsModel extends Model {

    public function __construct() {
        parent:: __construct();
    }

    public static function getProperty($key) {
        $query = Utils::getQuery("QUERY_GET_PROPERTY");
        $params = array('s', &$key);
        self::$mysql = new MySQL();
        $result = self::$mysql->selectForValueOrNull($query, 'VALUE', $params);
        self::$mysql->close();
        return $result;
    }

    public static function setProperty($key, $value) {
        $query = Utils::getQuery("QUERY_SET_PROPERTY");
        $params = array('ss', &$value, &$key);
        self::$mysql = new MySQL();
        self::$mysql->executeUpdate($query, $params);
        self::$mysql->close();
    }

}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace components;

use mysqli;
use ReflectionClass;

/**
 * Description of MySQL
 *
 * @author morozovr
 */
class MySQL {

    private $mysqli;

    public function __construct() {
        require 'config/config.php';
        $this->mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['dbname']);
        /* check connection */
        if (mysqli_connect_errno()) {
            throw new \Exception(Utils::getResource("ERR_CONNECT_FAILED"));
            exit();
        }
    }

    public function executeUpdate($query, $value = NULL) {
        $stmt = $this->mysqli->prepare($query);
        if (isset($value)) {
            $this->bindParameters($stmt, $value);
        }
        $stmt->execute();
        $stmt->close();
    }

    public function executeSelect($query, $value = NULL) {

        $stmt = $this->mysqli->prepare($query);
        if (isset($value)) {
            $this->bindParameters($stmt, $value);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $array = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($array, $row);
        }

        $stmt->close();

        return $array;
    }

    public function selectForValueOrNull($query, $column, $value = NULL) {
        $stmt = $this->mysqli->prepare($query);

        if (isset($value)) {
            $this->bindParameters($stmt, $value);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $result = $row[$column];
        $stmt->close();
        return $result;
    }

    public function selectForRuwnum($query, $value = NULL) {

        $stmt = $this->mysqli->prepare($query);

        if (isset($value)) {
            $this->bindParameters($stmt, $value);
        }

        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows;
        $stmt->close();

        return $result;
    }

    private function bindParameters($statement, $value) {
        $ref = new ReflectionClass('mysqli_stmt');
        $method = $ref->getMethod("bind_param");
        $method->invokeArgs($statement, $value);
    }

    public function commit() {
        $this->mysqli->commit();
    }

    public function close() {
        $this->mysqli->close();
    }

}

?>
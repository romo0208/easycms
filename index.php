<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use core\Application;

spl_autoload_register(function($name) {
            require_once(str_replace('\\', '/', $name) . '.php');
        });

ini_set('display_errors', 1);
$application = new Application();
?>

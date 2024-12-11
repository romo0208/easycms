<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotFoundController
 *
 * @author morozovr
 */

namespace controllers;

use controllers\GenericController;
use components\Utils;

class NotFoundController extends GenericController {

    public function __construct() {

        parent::__construct();
        $this->setSubViewPage("404.php");
    }

    public function getTitle() {
        return Utils::getResource('ERR_404') . parent::getTitle();
    }

}

?>

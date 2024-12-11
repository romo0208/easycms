<?php

namespace components;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileUploader
 *
 * @author morozovr
 */
use components\Utils;

class FileUploader {

    private $files;
    private $oldFileName;
    private $message;
    private $uploadedFileName;
    private $success = false;

    public function __construct($files, $oldFileName = NULL) {
        $this->files = $files;
        $this->oldFileName = $oldFileName;
    }

    public function upload() {
        if ($this->files) {
            if (($this->files == "none") OR (empty($this->files['name']))) {
                $this->message = Utils::getResource('RES_NO_FILE_CHOSEN');
                $this->success = false;
            } else if ($this->files["size"] == 0 OR $this->files["size"] > 2050000) {
                $this->message = Utils::getResource('RES_FILE_TOO_LARGE');
                $this->success = false;
            } else if (!(($this->files["type"] == "image/jpg") ||
                    ($this->files["type"] == "image/jpeg") ||
                    ($this->files["type"] == "image/pjpeg") ||
                    ($this->files["type"] == "image/png") ||
                    ($this->files["type"] == "image/x-png") ||
                    ($this->files["type"] == "image/gif"))) {
                $this->message = Utils::getResource('RES_FILE_HAS_WRONG_TYPE');
                $this->success = false;
            } else if (!is_uploaded_file($this->files["tmp_name"])) {
                $this->message = Utils::getResource('RES_TRY_AGAIN');
                $this->success = false;
            } else {
                $name = rand(1, 1000) . '-' . md5($this->files['name']) . '.' . Utils::getex($this->files['name']);
                move_uploaded_file($this->files['tmp_name'], "upload/" . $name);
                if (isset($this->oldFileName)) {
                    unlink($this->oldFileName);
                }
                $this->message = Utils::getResource('RES_FILE_UPLOADED') . $this->files['name'];
                $this->uploadedFileName = 'upload/' . $name;
                $this->success = true;
            }
        }
    }

    public function getMessage() {
        return $this->message;
    }

    public function isSuccessful() {
        return $this->success;
    }

    public function getUploadedFilename() {
        return $this->uploadedFileName;
    }

}

?>

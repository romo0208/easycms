<?php
spl_autoload_register(function($name) {
            require_once(str_replace('\\', '/', $name) . '.php');
        });

use models\SettingsModel;
use components\Utils;
use components\FileUploader;

$uploader = new FileUploader($_FILES['upload']);
$uploader->upload();
$message = $uploader->getMessage();
if ($uploader->isSuccessful()) {
    $full_path = SettingsModel::getProperty("easycms.domain") . '/' . $uploader->getUploadedFilename();
} else {
    $full_path = "";
}
$callback = $_REQUEST['CKEditorFuncNum'];
echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '", "' . $full_path . '", "' . $message . '" );</script>';
?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace components;

/**
 * Description of Utils
 *
 * @author morozovr
 */
use models\SettingsModel;
use components\MySQL;
use models\UserModel;

class Utils {

    const SALT = 'Spidola-231';

//put your code here
    public static function getUniqueID() {
        return crypt(time(), SALT);
    }

    public static function cryptPassword($password) {
        return crypt($password, SALT);
    }

    public static function getex($filename) {
        return end(explode(".", $filename));
    }

    public static function sendRegistrationEmail($user) {
        $login = $user->getLogin();
        $id = $user->getId();
        $email = $user->getEmail();
        $pending_id = $user->getPendingId();
        $settingsModel = new SettingsModel();

        $adminemail = $settingsModel->getProperty("easycms.adminemail");
        $sitename = $settingsModel->getProperty("easycms.sitename");
        $domain = $settingsModel->getProperty("easycms.domain");

        $subject = "Регистрация на сайте \"{$sitename}\"";
        $body = "Здравствуйте, {$login}!\nСпасибо за регистрацию на сайте \"{$sitename}\".\nДля завершения регистрации перейдите по ссылке:\n{$domain}/apply?user={$id}&pending={$pending_id}\nС уважением, команда {$domain}.";

        $headers = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=utf-8";
        $headers[] = "From: {$adminemail}";
        $headers[] = "X-Mailer: PHP/" . phpversion();

        mail($email, $subject, $body, implode("\r\n", $headers));
    }

    public static function sendCommentNotification($user, $post, $comment) {
        $postId = $post->getId();
        $userId = $user->getId();
        $mysql = new MySQL();
        $params = array('ii', &$postId, &$userId);
        $data = $mysql->executeSelect(static::getQuery('QUERY_GET_AFFECTED_USERS'), $params);
        $mysql->close();
        $caption = $post->getCaption();
        $settingsModel = new SettingsModel();
        $adminemail = $settingsModel->getProperty("easycms.adminemail");
        $domain = $settingsModel->getProperty("easycms.domain");
        foreach ($data as $row) {
            $model = new UserModel($row['user_id']);
            $login = $model->getLogin();
            $email = $model->getEmail();
            $subject = "Комментарий к записи \"{$caption}\"";
            $body = "Здравствуйте, {$login}!\nНа запись \"{$caption}\" пользователем " . $user->getLogin() . " оставлен комментарий: \n\"{$comment}\"\nДля просмотра комментария перейдите по ссылке:\n{$domain}/showpost?id={$postId}\nС уважением, команда {$domain}.";
            $headers = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/plain; charset=UTF-8";
            $headers[] = "From: {$adminemail}";
            $headers[] = "X-Mailer: PHP/" . phpversion();
            mail($email, $subject, $body, implode("\r\n", $headers));
        }
    }

    public static function getQuery($identifier) {
        require 'resources/queries.php';
        return $queries[$identifier];
    }

    public static function getResource($identifier) {
        require 'resources/strings.php';
        return $resources[$identifier];
    }

    public static function redirect($page, $message = NULL) {
        if (isset($message)) {
            header("Location: " . $page . "?result=" . $message);
        } else {
            header("Location: " . $page);
        }
    }

}

?>

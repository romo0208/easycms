<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$queries = array(
    'QUERY_SET_PROPERTY' => 'UPDATE `easy_settings`
   SET `easy_settings`.`VALUE` = ?
 WHERE `easy_settings`.`KEY` = ?',
    'QUERY_GET_PROPERTY' => 'SELECT `easy_settings`.`VALUE`
  FROM `easy_settings`
 WHERE `easy_settings`.`KEY` = ?',
    'QUERY_CREATE_USER' => 'INSERT INTO `easy_users`
            (`login`, `password`, `email`, `registration_date`, `pending_id`, `is_admin`,
             `ip_address`
            )
     VALUES (?, ?, ?, now(), ?, 0,
             ?
            )',
    'QUERY_GET_ID' => 'SELECT last_insert_id() `VALUE`
  FROM DUAL',
    'QUERY_GET_USER_BY_ID' => 'SELECT *
  FROM `easy_users`
 WHERE `user_id` = ?',
    'QUERY_ADMIN' => 'UPDATE `easy_users`
   SET `is_admin` = ?
 WHERE `user_id` = ?',
    'QUERY_MARK_CONFIRMED' => 'UPDATE `easy_users`
   SET `pending_id` = NULL
 WHERE `user_id` = ?',
    'QUERY_IS_CONFIRMED' => 'SELECT 1
  FROM `easy_users`
 WHERE `pending_id` IS NULL AND `user_id` = ?',
    'QUERY_SET_PASSWORD' => 'UPDATE `easy_users`
   SET `password` = ?
 WHERE `user_id` = ?',
    'QUERY_DELETE_USER' => 'DELETE FROM `easy_users`
      WHERE `user_id` = ?',
    'QUERY_MAINLIST' => 'SELECT   `post_id`,`caption`
    FROM `easy_posts`
   WHERE `is_main` = 1
ORDER BY `date` DESC',
    'QUERY_CHEK_USER_EXISTENCE_BY_CREDENTIALS' => 'SELECT 1
  FROM `easy_users`
 WHERE `login` = ? AND `PASSWORD` = ?',
    'QUERY_CHECK_EMAIL' => 'SELECT 1
  FROM `easy_users`
 WHERE `email` = ?',
    'QUERY_CHECK_LOGIN' => 'SELECT 1
  FROM `easy_users`
 WHERE `login` = ?',
    'QUERY_GET_POST_BY_ID' => 'SELECT *
  FROM `easy_posts`
 WHERE `post_id` = ?',
    'QUERY_SET_CAPTION' => 'UPDATE `easy_posts`
   SET `caption` = ?
 WHERE `post_id` = ?',
    'QUERY_SET_BODY' => 'UPDATE `easy_posts`
   SET `body` = ?
 WHERE `post_id` = ?',
    'QUERY_SET_PICTURE' => 'UPDATE `easy_posts`
   SET `picture` = ?
 WHERE `post_id` = ?',
    'QUERY_SET_VIDEO' => 'UPDATE `easy_posts`
   SET `video` = ?
 WHERE `post_id` = ?',
    'QUERY_MAIN' => 'UPDATE `easy_posts`
   SET `is_main` = ?
 WHERE `post_id` = ?',
    'QUERY_DELETE_POST' => 'DELETE FROM `easy_posts`
      WHERE `post_id` = ?',
    'QUERY_CREATE_POST' => 'INSERT INTO `easy_posts`
            (`caption`, `body`, `picture`, `video`, `user_id`, `date`
            )
     VALUES (?, ?, ?, ?, ?, now()
            )',
    'QUERY_GET_USER_ID_BY_LOGIN' => 'SELECT `user_id`
  FROM `easy_users`
 WHERE `login` = ?',
    'QUERY_GET_USER_NAME_BY_ID' => 'SELECT `login`
  FROM `easy_users`
 WHERE `user_id` = ?',
    'QUERY_GET_ALL_USERS' => 'SELECT `user_id`
  FROM `easy_users`',
    'QUERY_GET_ALL_POSTS' => "SELECT DISTINCT `posts`.`post_id`
           FROM `easy_posts` posts INNER JOIN `easy_users` users1
                ON (`posts`.`user_id` = `users1`.`user_id`)
                LEFT JOIN `easy_user_comments` comments
                ON (`posts`.`post_id` = `comments`.`post_id`)
                LEFT JOIN `easy_users` users2
                ON (`comments`.`user_id` = `users2`.`user_id`)
          WHERE (   LOWER (`posts`.`caption`) LIKE ?
                 OR LOWER (`posts`.`body`) LIKE ?
                 OR LOWER (`users1`.`login`) LIKE ?
                 OR LOWER (`comments`.`comment`) LIKE ?
                 OR LOWER (`users2`.`login`) LIKE ?
                )
       ORDER BY `posts`.`date` DESC LIMIT ?, ?",
    'QUERY_GET_ALL_POSTS2' => "SELECT DISTINCT `posts`.`post_id`
           FROM `easy_posts` posts INNER JOIN `easy_users` users1
                ON (`posts`.`user_id` = `users1`.`user_id`)
                LEFT JOIN `easy_user_comments` comments
                ON (`posts`.`post_id` = `comments`.`post_id`)
                LEFT JOIN `easy_users` users2
                ON (`comments`.`user_id` = `users2`.`user_id`)
          WHERE (   LOWER (`posts`.`caption`) LIKE ?
                 OR LOWER (`posts`.`body`) LIKE ?
                 OR LOWER (`users1`.`login`) LIKE ?
                 OR LOWER (`comments`.`comment`) LIKE ?
                 OR LOWER (`users2`.`login`) LIKE ?
                )
       ORDER BY `posts`.`date`",
    'QUERY_GET_COMMENT_BY_ID' => 'SELECT *
  FROM `easy_user_comments`
 WHERE `comment_id` = ?',
    'QUERY_DELETE_COMMENT' => 'DELETE FROM `easy_user_comments`
      WHERE `comment_id` = ?',
    'QUERY_CREATE_COMMENT' => 'INSERT INTO `easy_user_comments`
            (`user_id`, `post_id`, `comment`, `date`
            )
     VALUES (?, ?, ?, now()
            )',
    'QUERY_GET_ALL_COMMENTS' => 'SELECT `comment_id`
  FROM `easy_user_comments`
 WHERE `post_id` = ?',
    'QUERY_GET_AFFECTED_USERS' => 'SELECT DISTINCT `users`.`user_id`
           FROM `easy_posts` `posts`,
                `easy_users` `users`,
                `easy_user_comments` `comments`
          WHERE `posts`.`post_id` = ?
            AND (   `users`.`user_id` = `posts`.`user_id`
                 OR (    `users`.`user_id` = `comments`.`user_id`
                     AND `comments`.`post_id` = `posts`.`post_id`
                    )
                )
            AND `users`.`user_id` <> ?'
);
?>

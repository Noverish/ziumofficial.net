<?php
/**
  * Test 'send_noti' func. Only used for developing
  *
  * @author hyunsub.kim(embrapers263@gmail.com)
  * @param int $user_id
  * @param string $title
  * @param string $content
  * @param string $ticker
  * @param int $is_android      1 for android, 0 for iOS, -1 for unknown
  * @return none none           depending on 'send_noti' func
  */

    include_once('../config.php');
    include_once('send.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($title = $_POST["title"]) != NULL or print_error_and_die("There is no title");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    ($ticker = $_POST["ticker"]) != NULL or print_error_and_die("There is no ticker");
    ($is_android = $_POST["is_android"]) != NULL or ($is_android = -1);

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    send_noti($user_id, $title, $content, $ticker);
 ?>

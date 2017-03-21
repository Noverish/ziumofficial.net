<?php
    include_once('../config.php');
    include_once('send.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($title = $_POST["title"]) != NULL or print_error_and_die("There is no title");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    ($ticker = $_POST["ticker"]) != NULL or print_error_and_die("There is no ticker");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    send_noti($user_id, $title, $content, $ticker);
 ?>

<?php
    include('config.php');
    include('query_func.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_user_id_then_die($user_id);

    $sql = "INSERT INTO UserMsg (user_id, is_user_sent, is_user_read, content, date) VALUES ($user_id, 1, 1, '%s', now())";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

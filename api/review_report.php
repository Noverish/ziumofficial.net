<?php
    include('config.php');
    include('query_func.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_review_id_then_die($review_id);
    if_not_valid_user_id_then_die($user_id);

    $sql = "INSERT INTO ReviewReport (user_id, review_id, content, date, is_android, app_version) VALUES ($user_id, $review_id, '%s', now(), $is_android, $app_version)";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

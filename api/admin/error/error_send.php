<?php
    include('../../config.php');
    header('Content-type:text/html;charset=utf-8');

    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    $user_id = isset($_POST['user_id']) ? "'".$_POST['user_id']."'" : "NULL";
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $content = mysqli_real_escape_string($conn, $content);

    $sql="INSERT INTO Error (user_id, is_android, version, stack_trace, date) VALUES ($user_id, $is_android, $app_version, '$content', now())";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res['res'] = 1;
    $res['msg'] = "success";

    echo raw_json_encode($res);
?>

<?php
    include('../../config.php');
    header('Content-type:text/html;charset=utf-8');

    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");

    $content = mysqli_real_escape_string($conn, $content);

    $sql="INSERT INTO Error (stack_trace, date) VALUES ('$content', now())";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res['res'] = 1;
    $res['msg'] = "success";

    echo raw_json_encode($res);
?>

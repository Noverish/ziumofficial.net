<?php
    include('config.php');
    include('query_func.php');

    ($comment_id = $_POST["comment_id"]) != NULL or print_error_and_die("There is no comment_id");

    if(!is_numeric($comment_id)) print_error_and_die("comment_id is not number");

    $sql = "DELETE FROM Comment WHERE _id = $comment_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

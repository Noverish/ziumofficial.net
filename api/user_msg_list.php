<?php
    include('config.php');
    include('query_func.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    if_not_valid_user_id_then_die($user_id);

    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="UPDATE UserMsg SET is_user_read = 1 WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $sql="SELECT user_id, is_user_sent, is_user_read, content, date FROM UserMsg WHERE user_id = $user_id ORDER BY date DESC";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);
?>

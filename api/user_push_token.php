<?php
    include('config.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($token = $_POST["token"]) != NULL or print_error_and_die("There is no token");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    $sql="UPDATE User SET token = '$token' WHERE _id = $user_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

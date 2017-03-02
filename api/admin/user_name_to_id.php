<?php
    include('../config.php');
    include('../query_func.php');

    ($user_name = $_POST["user_name"]) != NULL or print_error_and_die("There is no user_name");

    $user_name = mysqli_real_escape_string($conn, $user_name);

    $sql = "SELECT _id FROM User WHERE user_name = '$user_name'";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if($result == null || $result == false || mysqli_num_rows($result) == 0)
        print_error_and_die("There is no user whose name is $user_name");
    else
        $row = mysqli_fetch_row($result);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["user_id"] = $row[0];

    echo raw_json_encode($res);
?>

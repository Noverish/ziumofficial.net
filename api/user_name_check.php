<?php
    include("config.php");

    $user_name = $_POST['user_name'] or print_error_and_die("There is no user_name");

    $sql = sprintf("SELECT user_name FROM User WHERE user_name = '%s'",
        mysqli_real_escape_string($conn, $user_name));
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die();

    $res["res"] = 1;
    $res["msg"] = 'success';
    $res["is_exist"] = mysqli_num_rows($result) != 0;

    echo raw_json_encode($res);
?>

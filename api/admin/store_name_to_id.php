<?php
    include('../config.php');
    include('../query_func.php');

    ($store_name = $_POST["store_name"]) != NULL or print_error_and_die("There is no store_name");

    $store_name = mysqli_real_escape_string($conn, $store_name);

    $sql = "SELECT _id FROM Store WHERE name = '$store_name'";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if($result == null || $result == false || mysqli_num_rows($result) == 0)
        print_error_and_die("There is no store whose name is $store_name");
    else
        $row = mysqli_fetch_row($result);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["store_id"] = $row[0];

    echo raw_json_encode($res);
?>

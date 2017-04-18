<?php
    include('config.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($category = $_POST["category"]) != NULL or print_error_and_die("There is no category");
    ($region = $_POST["region"]) != NULL or print_error_and_die("There is no region");
    ($type1 = $_POST["type1"]) != NULL or print_error_and_die("There is no type1");
    ($type2 = $_POST["type2"]) != NULL or print_error_and_die("There is no type2");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $sql="INSERT INTO HistorySearchOptionNew (user_id, category, region, type1, type2, date, is_android, app_version) VALUES ($user_id, $category, $region, $type1, $type2, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);

    $row["res"] = 1;
    $row["msg"] = "success";

    echo raw_json_encode($row);
?>

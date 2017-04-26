<?php
    include('config.php');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "NULL";
    ($category = $_POST["category"]) != NULL or print_error_and_die("There is no category");
    ($region = $_POST["region"]) != NULL or print_error_and_die("There is no region");
    ($type1 = $_POST["type1"]) != NULL or print_error_and_die("There is no type1");
    ($type2 = $_POST["type2"]) != NULL or print_error_and_die("There is no type2");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    if(!is_numeric($category)) print_error_and_die("category is not number");
    if(!is_numeric($region)) print_error_and_die("region is not number");
    if(!is_numeric($type1)) print_error_and_die("type1 is not number");
    if(!is_numeric($type2)) print_error_and_die("type2 is not number");

    $sql="SELECT _id as store_id FROM Store WHERE (category & $category != 0) AND (region & $region != 0) AND (type1 & $type1 != 0) AND (type2 & $type2 != 0) AND (close_date > now())";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);

    $history = "INSERT INTO HistorySearchRandom (user_id, category, region, type1, type2, date, is_android, app_version) VALUES ($user_id, $category, $region, $type1, $type2, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $history);
?>

<?php
    include('config.php');
    include('query_func.php');

    ($rcmd_id = $_POST["rcmd_id"]) != NULL or print_error_and_die("There is no rcmd_id");
    $user_id = isset($_POST['user_id']) ? "'".$_POST['user_id']."'" : "NULL";
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    if(!is_numeric($rcmd_id)) print_error_and_die("rcmd_id is not number");

    if_not_valid_rcmd_id_then_die($rcmd_id);

    $sql="SELECT img, IFNULL(store_id, -1) as store_id FROM CardNews WHERE rcmd_id = $rcmd_id ORDER BY position ASC";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);

    $sql_views = "UPDATE Rcmd SET views = views + 1 WHERE _id = $rcmd_id";
    $result = mysqli_query($conn, $sql_views);

    $sql = "INSERT INTO HistoryRcmd (user_id, rcmd_id, date, is_android, app_version) VALUES ($user_id, $rcmd_id, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);
?>

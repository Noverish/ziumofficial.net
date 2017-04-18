<?php
    include('config.php');

    $user_id = isset($_POST['user_id']) ? "'".$_POST['user_id']."'" : "NULL";
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $sql="SELECT _id as popup_id, url, type, data FROM Popup WHERE enable = 1 ORDER BY _id DESC LIMIT 0, 1";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    if(mysqli_num_rows($result) == 0){
        $res["res"] = 2;
        $res["msg"] = "no popup";
    } else {
        $res = mysqli_fetch_assoc($result);

        $res["res"] = 1;
        $res["msg"] = "success";
    }

    echo raw_json_encode($res);
?>

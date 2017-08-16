<?php
    include('config.php');

    $user_id = isset($_POST['user_id']) ? "'".$_POST['user_id']."'" : "NULL";
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $urls = array();

    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-06_2/1.JPG");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-06_2/2.JPG");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-06_2/3.JPG");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-06_2/4.JPG");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-06_2/5.JPG");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-06_2/6.JPG");

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $urls;

    echo raw_json_encode($res);

    $sql = "INSERT INTO HistoryCafeteria (user_id, date, is_android, app_version) VALUES ($user_id, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);
?>

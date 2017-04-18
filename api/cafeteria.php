<?php
    include('config.php');

    $user_id = isset($_POST['user_id']) ? "'".$_POST['user_id']."'" : "NULL";
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $urls = array();

    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-04_3/1.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-04_3/2.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-04_3/3.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-04_3/4.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-04_3/5.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/cafeteria/2017-04_3/6.jpg");

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $urls;

    echo raw_json_encode($res);

    $sql = "INSERT INTO HistoryCafeteria (user_id, date, is_android, app_version) VALUES ($user_id, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);
?>

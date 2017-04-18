<?php
    include('config.php');

    $urls = array();

    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/login/login_image_1.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/login/login_image_2.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/login/login_image_3.jpg");
    array_push($urls, "https://s3.ap-northeast-2.amazonaws.com/kusulang-asset/login/login_image_4.jpg");

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $urls;

    echo raw_json_encode($res);
?>

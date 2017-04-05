<?php
    include_once('config.php');

    ($is_android = $_POST["is_android"]) != NULL or print_error_and_die("There is is_android");

    if($is_android) {
        $res["version"] = "1.1.3";
    } else {
        $res["version"] = "1.1.2";
    }

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
 ?>

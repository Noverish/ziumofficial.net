<?php
    include('config.php');

    $store_id = $_POST["store_id"];
    $user_id = $_POST["user_id"];

    $now_str = date('Y-m-d H:i:s');
    $sql = "INSERT INTO UserDibs (user_id, store_id, date) VALUES ($user_id, $store_id, '$now_str')";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

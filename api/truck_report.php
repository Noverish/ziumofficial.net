<?php
    include('config.php');

    $user_id = $_POST["user_id"];
    $content = $_POST["content"];

    $now_str = date('Y-m-d H:i:s');
    $sql = "INSERT INTO TruckReport (user_id, truck_id, content, date) VALUES ($user_id, -1, '$content', '$now_str')";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

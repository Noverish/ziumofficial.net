<?php
    include('config.php');

    $user_id = $_POST["user_id"];

    $sql = "SELECT _id FROM UserMsg WHERE (user_id=$user_id) AND (is_user_sent=FALSE) AND (is_user_read=FALSE)";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["has_noti"] = (mysqli_num_rows($result) > 0);

    echo raw_json_encode($res);
?>

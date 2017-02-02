<?php
    include("config.php");

    $DISPLAY_USER_NUM = 10;

    $sql = "SELECT _id as user_id, user_name, is_owner, score FROM User ORDER BY score DESC LIMIT $DISPLAY_USER_NUM";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $response["res"] = 1;
    $response["msg"] = "success";
    $response["user_id"] = query_result_to_array($result);

    echo raw_json_encode($response);
?>

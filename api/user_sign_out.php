<?php
    include("config.php");

    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM User WHERE _id = $user_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $response["res"] = 1;
    $response["msg"] = "success";

    echo raw_json_encode($response);
?>

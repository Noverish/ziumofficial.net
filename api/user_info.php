<?php
    include("config.php");

    $user_id = $_POST["user_id"];

    $sql = "SELECT user_name, is_owner, score, FIND_IN_SET(score, (SELECT GROUP_CONCAT(score ORDER BY score DESC) FROM User)) AS rank FROM User WHERE _id = $user_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $data = mysqli_fetch_assoc($result);

    $data = array('res' => 1, 'msg' => 'success') + $data;

    echo raw_json_encode($data);
?>

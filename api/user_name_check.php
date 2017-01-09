<?php
    include("config.php");

    $input_name = $_POST['user_name'];

    $result_user = mysqli_query($conn,"SELECT user_name FROM User WHERE user_name='$input_name'") or print_error_and_die($mysqli_error($conn));

    $response["res"] = 1;
    $response["msg"] = 'success';
    $response["is_exist"] = mysqli_num_rows($result_user) != 0;

    echo raw_json_encode($response);
?>

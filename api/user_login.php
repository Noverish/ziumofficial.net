<?php
    include("config.php");

    $input_id = $_POST['kakaoID'];

    $result_user = mysqli_query($conn,"SELECT _id FROM User WHERE kakaoID=$input_id") or print_error_and_die($mysqli_error($conn));

    if (mysqli_num_rows($result_user) == 0) {
        $response["res"] = 2;
        $response["msg"] = "회원가입 되지 않은 유저입니다.";
        die(raw_json_encode($response));
    }

    $row_user_id = mysqli_fetch_array($result_user);

    $response["res"] = 1;
    $response["msg"] = "success";
    $response["user_id"] = $row_user_id["_id"];

    echo raw_json_encode($response);
?>

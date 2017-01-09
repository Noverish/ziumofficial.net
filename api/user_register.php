<?php
    include("config.php");

    $input_name = $_POST['user_name'];
    $input_id = $_POST['kakaoID'];

    $result_user = mysqli_query($conn,"SELECT user_name, kakaoID FROM User WHERE (user_name='$input_name') OR (kakaoID='$input_id')") or print_error_and_die($mysqli_error($conn));

    if (mysqli_num_rows($result_user) > 0) {
        $response["res"] = 2;
        $response["msg"] = "이미 가입된 유저입니다";
        die(json_encode($response));
    }

    $sql = "INSERT into User (kakaoID,user_name,is_owner,push,reg_date,score,warning,views) VALUES ($input_id,'$input_name',0,0,now(),0,0,0)";
    $result_register = mysqli_query($conn,$sql) or print_error_and_die($mysqli_error($conn));

    $result_register = mysqli_query($conn,"SELECT _id FROM User WHERE user_name='$input_name'") or print_error_and_die($mysqli_error($conn));

    if (mysqli_num_rows($result_register) == 0) {
        $response["res"] = 0;
        $response["msg"] = "회원ID를 가져오지 못했습니다.";
        die(json_encode($response));
    }

    $row_user_id = mysqli_fetch_array($result_register);

    $response["res"] = 1;
    $response["msg"] = "success";
    $response["user_id"] = $row_user_id["_id"];

    echo json_encode($response);
?>

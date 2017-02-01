<?php
    include("config.php");

    $user_name = $_POST['user_name'] or print_error_and_die("There is no user_name");
    $kakaoID = $_POST['kakaoID'] or print_error_and_die("There is no kakaoID");

    $sql_user = sprintf("SELECT user_name, kakaoID FROM User WHERE user_name = '%s' OR kakaoID = %s",
        mysqli_real_escape_string($conn, $user_name),
        mysqli_real_escape_string($conn, $kakaoID));
    $result_user = mysqli_query($conn, $sql_user) or print_sql_error_and_die();
    $row_user = mysqli_fetch_assoc($result_user);

    if (mysqli_num_rows($result_user) > 0) {
        $res["res"] = 2;
        $res["msg"] = ($row_user["user_name"] == $user_name) ? "이미 사용 중인 닉네임 입니다" : "이미 가입된 유저입니다";
        die(raw_json_encode($res));
    }

    $sql_register = sprintf("INSERT into User (kakaoID, user_name, is_owner, push, reg_date, score, warning, views) ".
                            "VALUES (%s, '%s', 0, 0, now(), 0, 0, 0)",
        mysqli_real_escape_string($conn, $kakaoID),
        mysqli_real_escape_string($conn, $user_name));
    $result_register = mysqli_query($conn, $sql_register) or print_sql_error_and_die();

    $sql_id = sprintf("SELECT _id FROM User WHERE user_name='%s'",
        mysqli_real_escape_string($conn, $user_name));
    $result_id = mysqli_query($conn, $sql_id) or print_sql_error_and_die();
    $row_id = mysqli_fetch_array($result_id);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["user_id"] = $row_id["_id"];

    echo raw_json_encode($res);
?>

<?php
    include("config.php");

    ($kakaoID = $_POST['kakaoID']) != NULL or print_error_and_die("There is no kakaoID");
    $token = isset($_POST['token']) ? "'".$_POST['token']."'" : "NULL";
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $sql = sprintf("SELECT _id, (SELECT COUNT(*) > 0 FROM UserMsg WHERE user_id = User._id AND is_user_sent = FALSE AND is_user_read = FALSE) AS has_noti, push FROM User WHERE kakaoID = %s",
        mysqli_real_escape_string($conn, $kakaoID));
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) == 0) {
        $res["res"] = 2;
        $res["msg"] = "회원가입 되지 않은 유저입니다.";
    } else {
        $res["res"] = 1;
        $res["msg"] = "success";
        $res["user_id"] = $row["_id"];
        $res["has_noti"] = $row["has_noti"] != 0;
        $res["push"] = $row["push"];
    }

    echo raw_json_encode($res);

    if($res["res"] == 1) {
        $sql = "UPDATE User SET token = $token WHERE _id = ".$row["_id"];
        $result = mysqli_query($conn, $sql);

        $user_id = $row['_id'];

        $sql = "SELECT * FROM HistoryLoginNew WHERE user_id = $user_id && date(date) = date(now())";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0) {
            $sql = "UPDATE User SET score = score + $SCORE_ATTEND WHERE _id = $user_id";
            mysqli_query($conn, $sql);
        }

        $sql = "INSERT INTO HistoryLoginNew (user_id, date, is_android, app_version) VALUES ($user_id, now(), $is_android, $app_version)";
        $result = mysqli_query($conn, $sql);
    }
?>

<?php
    include("config.php");

    ($kakaoID = $_POST['kakaoID']) != NULL or print_error_and_die("There is no kakaoID");

    $sql = sprintf("SELECT _id, (SELECT COUNT(*) > 0 FROM UserMsg WHERE user_id = User._id AND is_user_sent = FALSE AND is_user_read = FALSE) AS has_noti FROM User WHERE kakaoID = %s",
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
    }

    echo raw_json_encode($res);

    $user_id = $row['_id'];
    $sql_history = "INSERT INTO HistoryLogin (user_id, date) VALUES ($user_id, now())";
    if(mysqli_query($conn, $sql_history)) {
        $sql_score = "UPDATE User SET score = score + $SCORE_ATTEND WHERE _id = $user_id";
        mysqli_query($conn, $sql_score);
    } else {
        $sql_score = "UPDATE HistoryLogin SET login_today = login_today + 1 WHERE user_id = $user_id AND date = now()";
        mysqli_query($conn, $sql_score);
    }
?>

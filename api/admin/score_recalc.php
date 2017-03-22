<?php
    include('../config.php');

    $user_id = $_POST["user_id"] or print_error_and_die("There is no user_id");

    mysqli_query($conn, "START TRANSACTION");

    $sql_user = "SELECT * FROM User WHERE _id = $user_id";
    $result_user = mysqli_query($conn, $sql_user) or print_sql_error_and_die($conn, $sql_user);
    while($row_user = mysqli_fetch_assoc($result_user)) {
        $user_id = $row_user['_id'];
        if($row_user['kakaoID'] > 99999999) {
            echo($user_id." ");

            $sql_login = "SELECT COUNT(*) FROM HistoryLogin WHERE user_id = $user_id";
            $result_login = mysqli_query($conn, $sql_login) or print_sql_error_and_die($conn, $sql_login);
            $row_login = mysqli_fetch_array($result_login);
            $score_login = $SCORE_ATTEND * $row_login[0];
            echo($score_login." ");

            $sql_review = "SELECT IF(COUNT(write_date) > $SCORE_REVIEW_MAX, $SCORE_REVIEW_MAX, COUNT(write_date)) FROM Review WHERE user_id = $user_id GROUP BY date(write_date)";
            $result_review = mysqli_query($conn, $sql_review) or print_sql_error_and_die($conn, $sql_review);
            $score_review = 0;
            while($row_review = mysqli_fetch_array($result_review)) {
                $score_review += $SCORE_REVIEW * $row_review[0];
            }
            echo($score_review." ");

            $sql_send_like = "SELECT IF(COUNT(date) > $SCORE_SENT_LIKE_MAX, $SCORE_SENT_LIKE_MAX, COUNT(date)) FROM UserLikes WHERE user_id = $user_id GROUP BY date(date)";
            $result_send_like = mysqli_query($conn, $sql_send_like) or print_sql_error_and_die($conn, $sql_send_like);
            $score_send_like = 0;
            while($row_send_like = mysqli_fetch_array($result_send_like)) {
                $score_send_like += $SCORE_SENT_LIKE * $row_send_like[0];
            }
            echo($score_send_like." ");

            $sql_rcvd_like = "SELECT (SELECT COUNT(*) FROM UserLikes WHERE review_id = Review._id) FROM Review WHERE user_id = $user_id";
            $result_rcvd_like = mysqli_query($conn, $sql_rcvd_like) or print_sql_error_and_die($conn, $sql_rcvd_like);
            $score_rcvd_like = 0;
            while($row_rcvd_like = mysqli_fetch_array($result_rcvd_like)) {
                $score_rcvd_like += $SCORE_RCVD_LIKE * $row_rcvd_like[0];
            }
            echo($score_rcvd_like." ");

            $score = $score_login + $score_review + $score_send_like + $score_rcvd_like;
        } else {
            $score = -1;
        }
        echo($score."\n");

        $sql_score = "UPDATE User SET score = $score WHERE _id = $user_id";
        $result_score = mysqli_query($conn, $sql_score) or print_sql_error_and_die($conn, $sql_score);
    }

    mysqli_query($conn, "COMMIT");

    echo("SUCCESS")
?>

<?php
    include('config.php');
    include('query_func.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_review_id_then_die($review_id);
    if_not_valid_user_id_then_die($user_id);

    $sql = "SELECT _id, date FROM UserLikes WHERE user_id = $user_id AND review_id = $review_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    if(mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO UserLikes (user_id, review_id, date) VALUES ($user_id, $review_id, now())";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 1;

        $write_date = date("Y-m-d H:i:s");
    } else {
        $row = mysqli_fetch_assoc($result);
        $write_date = $row['date'];
        //This must be above from below lines

        $sql = "DELETE FROM UserLikes WHERE user_id = $user_id AND review_id = $review_id";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 0;
    }

    echo raw_json_encode($res);

    $sql = "SELECT _id FROM UserLikes WHERE date(date) = date('$write_date')";
    $result = mysqli_query($conn, $sql);
    if($res["is_user_liked"] == 1) {
        if(mysqli_num_rows($result) <= $SCORE_SENT_LIKE_MAX) {
            $sql = "UPDATE User SET score = score + $SCORE_SENT_LIKE WHERE _id = $user_id";
            $result = mysqli_query($conn, $sql);
        }

        $sql = "UPDATE User SET score = score + $SCORE_RCVD_LIKE WHERE _id = (SELECT user_id FROM Review WHERE _id = $review_id)";
        $result = mysqli_query($conn, $sql);
    } else {
        if(mysqli_num_rows($result) < $SCORE_SENT_LIKE_MAX) {
            $sql = "UPDATE User SET score = score - $SCORE_SENT_LIKE WHERE _id = $user_id";
            $result = mysqli_query($conn, $sql);
        }

        $sql = "UPDATE User SET score = score - $SCORE_RCVD_LIKE WHERE _id = (SELECT user_id FROM Review WHERE _id = $review_id)";
        $result = mysqli_query($conn, $sql);
    }
?>

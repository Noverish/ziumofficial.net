<?php
/**
  * Toggle user like of review
  * If user already liked this review, then unlike it. vice versa.
  *
  * @author hyunsub.kim(embrapers263@gmail.com)
  * @param int $review_id
  * @param int $user_id
  * @param int $is_android      1 for android, 0 for iOS, -1 for unknown
  * @return int is_user_liked   1 for true, 0 for false
  */

    include('config.php');
    include('query_func.php');
    include('fcm/send.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

//[Nullable Key] Old version app does not send below keys
    ($is_android = $_POST["is_android"]) != NULL or ($is_android = -1);
//[Nullable Key] End

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_review_id_then_die($review_id);
    if_not_valid_user_id_then_die($user_id);

    //Find out whether user liked the review by counting number of rows from 'UserLikes' table
    $sql = "SELECT _id, date FROM UserLikes WHERE user_id = $user_id AND review_id = $review_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    //If user does not like the review yet
    if(mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO UserLikes (user_id, review_id, date) VALUES ($user_id, $review_id, now())";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 1;

        //For updating user score
        $write_date = date("Y-m-d H:i:s");

//[Push Noti] Start
        //Find out reviewer's user_id for preparation of sending push noti to reviewer
        $sql = "SELECT user_id FROM Review WHERE _id = $review_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $other_user_id = $row["user_id"];

        //Find out whether reviewer allowed push noti for like
        //If allowed, send push noti to reviewer
        $sql = "SELECT push FROM User WHERE _id = $other_user_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $push = $row["push"];
        if($push & 4 != 0)
            send_noti($other_user_id, "KU슐랭", "내 후기가 공감을 받았습니다.", "KU슐랭 : 내 후기가 공감받았어요~", $is_android);
//[Push Noti] End

    //If user already liked the review
    } else {

        //$write_date is for updating user score
        //This must be above from below sql query for deletion
        $row = mysqli_fetch_assoc($result);
        $write_date = $row['date'];

        $sql = "DELETE FROM UserLikes WHERE user_id = $user_id AND review_id = $review_id";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 0;
    }

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);

//[User Score Update] Start
    $sql = "SELECT _id FROM UserLikes WHERE date(date) = date('$write_date')";
    $result = mysqli_query($conn, $sql);

    //If user liked the review
    if($res["is_user_liked"] == 1) {

        //If liked user does not exceed score limit, then add score
        if(mysqli_num_rows($result) <= $SCORE_SENT_LIKE_MAX) {
            $sql = "UPDATE User SET score = score + $SCORE_SENT_LIKE WHERE _id = $user_id";
            $result = mysqli_query($conn, $sql);
        }

        //Updating reviewer's score
        $sql = "UPDATE User SET score = score + $SCORE_RCVD_LIKE WHERE _id = (SELECT user_id FROM Review WHERE _id = $review_id)";
        $result = mysqli_query($conn, $sql);

    //If user unliked the review
    } else {

        //If this unlike affected user's score, then subtract score
        if(mysqli_num_rows($result) < $SCORE_SENT_LIKE_MAX) {
            $sql = "UPDATE User SET score = score - $SCORE_SENT_LIKE WHERE _id = $user_id";
            $result = mysqli_query($conn, $sql);
        }

        //Updating reviewer's score
        $sql = "UPDATE User SET score = score - $SCORE_RCVD_LIKE WHERE _id = (SELECT user_id FROM Review WHERE _id = $review_id)";
        $result = mysqli_query($conn, $sql);
    }
//[User Score Update] End
?>

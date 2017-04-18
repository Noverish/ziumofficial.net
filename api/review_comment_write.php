<?php
/**
  * Toggle user like of review
  * If user already liked this review, then unlike it. vice versa.
  *
  * @author hyunsub.kim(embrapers263@gmail.com)
  * @param int $review_id
  * @param int $user_id
  * @param string $content
  * @param int $is_android      1 for android, 0 for iOS, -1 for unknown
  * @return int comment_id
  */

    include('config.php');
    include('query_func.php');
    include('fcm/send.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");

//[Nullable Key] Old version app does not send below keys
    ($is_android = $_POST["is_android"]) != NULL or ($is_android = -1);
//[Nullable Key] End

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_review_id_then_die($review_id);
    if_not_valid_user_id_then_die($user_id);

    $sql =
        "INSERT INTO Comment (review_id, user_id, content, date) ".
        "VALUES ($review_id, $user_id, '%s', now())";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $sql = "SELECT MAX(_id) FROM Comment";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["comment_id"] = $row[0];

    echo raw_json_encode($res);

//[Push Noti] Start
    //Find out reviewer's user_id for preparation of sending push noti to reviewer
    $sql = "SELECT user_id FROM Review WHERE _id = $review_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $other_user_id = $row["user_id"];

    //Find out whether reviewer allowed push noti for comment
    //If allowed, send push noti to reviewer
    $sql = "SELECT push FROM User WHERE _id = $other_user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $push = $row["push"];
    if($push & 8 != 0)
        send_noti($other_user_id, "KU슐랭", "내가 쓴 후기에 댓글이 달렸습니다.", "KU슐랭 : 내가 쓴 후기에 댓글이 달렸어요~", $is_android);
//[Push Noti] End
?>

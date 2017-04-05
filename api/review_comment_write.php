<?php
    include('config.php');
    include('query_func.php');
    include('fcm/send.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");

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

    $sql = "SELECT user_id FROM Review WHERE _id = $review_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $other_user_id = $row["user_id"];

    $sql = "SELECT push FROM User WHERE _id = $other_user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $push = $row["push"];
    if($push & 8 != 0)
        send_noti($other_user_id, "KU슐랭", "내가 쓴 후기에 댓글이 달렸습니다.", "KU슐랭 : 내가 쓴 후기에 댓글이 달렸어요~");
?>

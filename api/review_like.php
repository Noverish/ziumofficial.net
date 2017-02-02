<?php
    include('config.php');
    include('query_func.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_review_id_then_die($review_id);
    if_not_valid_user_id_then_die($user_id);

    $sql = "SELECT _id FROM UserLikes WHERE user_id = $user_id AND review_id = $review_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    if(mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO UserLikes (user_id, review_id, date) VALUES ($user_id, $review_id, now())";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 1;
    } else {
        $sql = "DELETE FROM UserLikes WHERE user_id = $user_id AND review_id = $review_id";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 0;
    }

    echo raw_json_encode($res);
?>

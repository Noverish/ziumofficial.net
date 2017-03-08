<?php
    include('config.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    $sql = "SELECT _id, write_date FROM Review WHERE _id = $review_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    if(mysqli_num_rows($result) == 0)
        print_error_and_die("Review can only deleted by writer");
    else {
        $row = mysqli_fetch_assoc($result);
        $write_date = $row['write_date'];
    }

    $sql = "DELETE FROM Review WHERE _id = $review_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);

    $sql = "SELECT _id FROM Review WHERE user_id = $user_id AND date(write_date) = date('$write_date')";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= ($SCORE_REVIEW_MAX - 1)) {
        // The reason of subtraction 1 from score_review_max is this review is already deleted
        $sql = "UPDATE User SET score = score - $SCORE_REVIEW WHERE _id = $user_id";
        $result = mysqli_query($conn, $sql);
    }
?>

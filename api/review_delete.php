<?php
    include('config.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    $sql = "SELECT _id FROM Review WHERE _id = $review_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    if(mysqli_num_rows($result) == 0)
        print_error_and_die("Review can only deleted by writer");

    $sql = "DELETE FROM Review WHERE _id = $review_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

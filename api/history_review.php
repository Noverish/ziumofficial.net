<?php
    include('config.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    $sql="INSERT INTO HistoryReview (user_id, review_id, date, is_android, app_version) VALUES ($user_id, $review_id, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);

    $sql_views = "UPDATE Review SET views = views + 1 WHERE _id = $review_id";
    mysqli_query($conn, $sql_views);

    $row["res"] = 1;
    $row["msg"] = "success";

    echo raw_json_encode($row);
?>

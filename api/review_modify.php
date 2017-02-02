<?php
    include('config.php');
    include('query_func.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($star = $_POST["star"]) != NULL or print_error_and_die("There is no star");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    ($img1 = $_POST["img1"]) != NULL or ($img1 = "NULL");
    ($img2 = $_POST["img2"]) != NULL or ($img2 = "NULL");
    ($img3 = $_POST["img3"]) != NULL or ($img3 = "NULL");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($star)) print_error_and_die("star is not number");

    if_not_valid_review_id_then_die($review_id);

    $sql = "UPDATE Review SET star_rate = $star, content = '%s', img1 = '$img1', img2 = '$img2', img3 = '$img3', modify_date = now() WHERE _id = $review_id";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

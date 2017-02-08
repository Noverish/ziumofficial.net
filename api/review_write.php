<?php
    include('config.php');
    include('query_func.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");
    ($star = $_POST["star"]) != NULL or print_error_and_die("There is no star");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    ($img1 = $_POST["img1"]) != NULL or ($img1 = "NULL");
    ($img2 = $_POST["img2"]) != NULL or ($img2 = "NULL");
    ($img3 = $_POST["img3"]) != NULL or ($img3 = "NULL");

    if(strcmp($img1,"NULL") != 0) $img1 = "'".$img1."'";
    if(strcmp($img2,"NULL") != 0) $img2 = "'".$img2."'";
    if(strcmp($img3,"NULL") != 0) $img3 = "'".$img3."'";

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");
    if(!is_numeric($star)) print_error_and_die("star is not number");

    if_not_valid_user_id_then_die($user_id);
    if_not_valid_store_id_then_die($store_id);

    $sql =
        "INSERT INTO Review (user_id, store_id, star_rate, content, img1, img2, img3, write_date) ".
        "VALUES ($user_id, $store_id, '$star', '%s', $img1, $img2, $img3, now())";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);

    $sql_score = "SELECT COUNT(_id) FROM Review WHERE user_id = $user_id AND date(write_date) = date(now())";
    $result_score = mysqli_query($conn, $sql_score);
    $row_score = mysqli_fetch_array($result_score);
    if($row_score[0] <= $SCORE_REVIEW_MAX) {
        $sql_score = "UPDATE User SET score = score + $SCORE_REVIEW WHERE _id = $user_id";
        mysqli_query($conn, $sql_score);
    }
?>

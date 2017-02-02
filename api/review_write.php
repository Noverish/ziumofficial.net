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

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");
    if(!is_numeric($star)) print_error_and_die("star is not number");

    if_not_valid_user_id_then_die($user_id);
    if_not_valid_store_id_then_die($store_id);

    $sql =
        "INSERT INTO Review (user_id, store_id, star_rate, content, img1, img2, img3, write_date) ".
        "VALUES ($user_id, $store_id, '$star', '%s', '$img1', '$img2', '$img3', now())";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

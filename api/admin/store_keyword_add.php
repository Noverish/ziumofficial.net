<?php
    include('../config.php');
    include('../query_func.php');

    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");
    ($keyword = $_POST["keyword"]) != NULL or print_error_and_die("There is no keyword");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");

    $keyword = mysqli_real_escape_string($conn, $keyword);

    $sql = "INSERT INTO StoreKeyword (store_id, keyword) VALUES ($store_id, '$keyword')";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

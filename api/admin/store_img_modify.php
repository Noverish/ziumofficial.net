<?php
    include('../config.php');
    include('../query_func.php');

    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");
    ($img = $_POST["img"]) != NULL or print_error_and_die("There is no img");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");

    if_not_valid_store_id_then_die($store_id);

    $img = mysqli_real_escape_string($conn, $img);

    $sql = "UPDATE Store SET img = '$img' WHERE _id = $store_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

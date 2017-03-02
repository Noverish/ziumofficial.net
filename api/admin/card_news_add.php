<?php
    include('../config.php');
    include('../query_func.php');

    ($rcmd_id = $_POST["rcmd_id"]) != NULL or print_error_and_die("There is no rcmd_id");
    ($position = $_POST["position"]) != NULL or print_error_and_die("There is no position");
    ($img = $_POST["img"]) != NULL or print_error_and_die("There is no img");
    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");

    if(!is_numeric($rcmd_id)) print_error_and_die("rcmd_id is not number");
    if(!is_numeric($position)) print_error_and_die("position is not number");
    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");

    if_not_valid_rcmd_id_then_die($rcmd_id);
    if($store_id != -1)
        if_not_valid_store_id_then_die($store_id);
    else
        $store_id = "NULL";

    $img = mysqli_real_escape_string($conn, $img);

    $sql = "INSERT INTO CardNews (rcmd_id, position, img, store_id) VALUES ($rcmd_id, $position, '$img', $store_id)";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

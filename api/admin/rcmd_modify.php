<?php
    include('../config.php');
    include('../query_func.php');

    ($rcmd_id = $_POST["rcmd_id"]) != NULL or print_error_and_die("There is no rcmd_id");
    ($img = $_POST["img"]) != NULL or print_error_and_die("There is no img");

    if(!is_numeric($rcmd_id)) print_error_and_die("rcmd_id is not number");

    if_not_valid_rcmd_id_then_die($rcmd_id);

    $img = mysqli_real_escape_string($conn, $img);

    $sql = "UPDATE Rcmd SET img = '$img' WHERE _id = $rcmd_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

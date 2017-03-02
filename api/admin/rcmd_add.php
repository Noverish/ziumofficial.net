<?php
    include('../config.php');
    include('../query_func.php');

    ($img = $_POST["img"]) != NULL or print_error_and_die("There is no img");

    $img = mysqli_real_escape_string($conn, $img);

    $sql = "INSERT INTO Rcmd (title, img, date) VALUES ('', '$img', now())";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["rcmd_id"] = mysqli_insert_id($conn);

    echo raw_json_encode($res);
?>

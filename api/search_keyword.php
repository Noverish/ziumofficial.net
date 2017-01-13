<?php
    include('config.php');

    $keyword = $_POST["keyword"];
    $page = $_POST["page"];

    $sql="SELECT _id FROM Store WHERE (name LIKE '%$keyword%')";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = array_slice(query_result_to_array($result),$PAGE_SIZE * ($page - 1),$PAGE_SIZE);

    echo raw_json_encode($res);
?>

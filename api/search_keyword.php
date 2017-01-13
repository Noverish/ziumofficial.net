<?php
    include('config.php');
    include('query_func.php');

    $keyword = $_POST["keyword"];
    $page = $_POST["page"];

    $sql="SELECT * FROM Store WHERE (name LIKE '%$keyword%')";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = array_slice(get_store_array($result),$PAGE_SIZE * ($page - 1),$PAGE_SIZE);

    echo raw_json_encode($res);
?>

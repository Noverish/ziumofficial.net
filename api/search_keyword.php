<?php
    include('config.php');
    include('query_func.php');

    $keyword = $_POST["keyword"];
    $page = $_POST["page"];
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="SELECT * FROM Store WHERE (name LIKE '%$keyword%') LIMIT $page_offset, $PAGE_SIZE";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = get_store_array($result);

    echo raw_json_encode($res);
?>

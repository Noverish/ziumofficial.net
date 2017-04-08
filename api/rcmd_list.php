<?php
    include('config.php');

    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($page)) print_error_and_die("page is not number");

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="SELECT _id as rcmd_id, title, img, date FROM Rcmd WHERE enable = TRUE ORDER BY priority ASC LIMIT $page_offset, $PAGE_SIZE";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);
?>

<?php
    include('config.php');

    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($page)) print_error_and_die("page is not number");

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="SELECT Event._id AS event_id, store_id, Store.name AS store_name, content, is_open ".
         "FROM Event ".
         "INNER JOIN Store ON Event.store_id = Store._id ".
         "ORDER BY is_open DESC, Event.priority DESC, Event.date DESC ".
         "LIMIT $page_offset, $PAGE_SIZE";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);
?>

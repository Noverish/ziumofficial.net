<?php
    include('config.php');

    $page = $_POST["page"];
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="SELECT Event._id AS event_id, Event.store_id, Store.name AS store_name, Event.content, Event.is_open, Event.date ".
         "FROM Event ".
         "INNER JOIN Store ON Event.store_id = Store._id ".
         "ORDER BY Event.priority DESC, Event.date DESC ".
         "LIMIT $page_offset, $PAGE_SIZE";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $data = query_result_to_array($result);

    // array_walk($data, function (& $item) {
    //     $item = array('event_id' => $item['_id']) + $item;
    //     unset($item['_id']);
    // });

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $data;

    echo raw_json_encode($res);
?>

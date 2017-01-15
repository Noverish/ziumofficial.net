<?php
    include('config.php');

    $page = $_POST["page"];

    $sql="SELECT _id, img_title FROM Event ORDER BY priority DESC, date DESC";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $data = query_result_to_array($result);

    array_walk($data, function (& $item) {
        $item = array('event_id' => $item['_id']) + $item;
        unset($item['_id']);
    });

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = array_slice($data,$PAGE_SIZE * ($page - 1),$PAGE_SIZE);

    echo raw_json_encode($res);
?>

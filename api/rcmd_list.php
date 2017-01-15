<?php
    include('config.php');

    $page = $_POST["page"];
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="SELECT _id, title, img, date FROM Rcmd ORDER BY priority DESC, date DESC LIMIT $page_offset, $PAGE_SIZE";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $data = query_result_to_array($result);

    array_walk($data, function (& $item) {
        $item = array('rcmd_id' => $item['_id']) + $item;
        unset($item['_id']);
    });

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $data;

    echo raw_json_encode($res);
?>

<?php
    include('config.php');

    $sql="SELECT * FROM Truck";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $data = query_result_to_array($result);

    array_walk($data, function (& $item) {
        $item = array('truck_id' => $item['_id']) + $item;
        unset($item['_id']);
    });

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $data;

    echo raw_json_encode($res);
?>

<?php
    include('config.php');

    $event_id = $_POST["event_id"];

    $sql = "SELECT title, content, img_main, event_start, event_end, date FROM Event WHERE _id = $event_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $tmp = query_result_to_array($result);
    $res = $tmp[0];

    $res = array('res' => 1, 'msg' => 'success') + $res;

    echo raw_json_encode($res);
?>

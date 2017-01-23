<?php
    include('config.php');
    include('query_func.php');

    $store_id = $_POST["store_id"];

    $sql="SELECT * FROM Store WHERE _id = $store_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res = get_store_array($result);
    $res = $res[0];
    $res = array('res' => 1, 'msg' => 'success') + $res;

    echo raw_json_encode($res);
?>

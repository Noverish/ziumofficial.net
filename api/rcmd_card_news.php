<?php
    include('config.php');

    $rcmd_id = $_POST["rcmd_id"];

    $sql="SELECT img, store_id FROM CardNews ORDER BY position ASC";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $data = query_result_to_array($result);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $data;

    echo raw_json_encode($res);
?>

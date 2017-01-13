<?php
    include('config.php');
    include('query_func.php');

    $store_id = $_POST["store_id"];
    $page = $_POST["page"];

    $sql_review = "SELECT * FROM Review WHERE store_id = $store_id";
    $result_review = mysqli_query($conn, $sql_review) or print_error_and_die(mysqli_error($conn));

    $reviews = get_review_array($result_review);

    $res['res'] = 1;
    $res['msg'] = 'success';
    $res['reviews'] = $reviews;

    echo raw_json_encode($res);
?>

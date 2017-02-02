<?php
    include('config.php');

    $user_id = $_POST["user_id"];
    $page = $_POST["page"];
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql_review = "SELECT * FROM Review WHERE user_id = $user_id ORDER BY write_date DESC LIMIT $page_offset, $PAGE_SIZE";
    $result_review = mysqli_query($conn, $sql_review) or print_error_and_die(mysqli_error($conn));

    $reviews = get_review_array($result_review);

    $res['res'] = 1;
    $res['msg'] = 'success';
    $res['reviews'] = $reviews;

    echo raw_json_encode($res);
?>

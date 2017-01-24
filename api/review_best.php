<?php
    include('config.php');
    include('query_func.php');

    $page = $_POST["page"];
    $page_offset = $PAGE_SIZE * ($page - 1);

    $reviews = array();
    $sql_like = "SELECT review_id, COUNT(*) AS magnitude FROM UserLikes GROUP BY review_id ORDER BY magnitude DESC LIMIT $page_offset, $PAGE_SIZE";
    $result_like = mysqli_query($conn, $sql_like) or print_error_and_die(mysqli_error($conn));
    while($row_like = mysqli_fetch_assoc($result_like)) {
        $review_id = $row_like["review_id"];
        $sql_review = "SELECT * FROM Review WHERE _id = $review_id";
        $result_review = mysqli_query($conn, $sql_review) or print_error_and_die(mysqli_error($conn));

        $tmp = query_result_to_array($result_review);
        $tmp[0]["like_num"] = $row_like["magnitude"];
        $reviews[] = add_review_extra_data($tmp[0]);
    }

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["reviews"] = $reviews;

    echo(raw_json_encode($res));
?>

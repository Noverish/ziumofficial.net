<?php
    include('config.php');
    include('query_func.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    if_not_valid_review_id_then_die($review_id);

    $sql=
        "SELECT Comment._id as comment_id, user_id, User.user_name, User.is_owner, content, date ".
        "FROM Comment ".
        "INNER JOIN User ON User._id = Comment.user_id ".
        "WHERE review_id = $review_id ".
        "LIMIT $page_offset, $PAGE_SIZE ";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);
?>

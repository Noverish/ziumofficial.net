<?php
    include('config.php');
    include('query_func.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    if_not_valid_user_id_then_die($user_id);

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql_review =
        "SELECT Review._id as review_id, Store._id as store_id, Store.name as store_name, ".
        "user_id, User.user_name, User.is_owner, star_rate, content, img1, img2, img3, ".
        "(SELECT COUNT(_id) FROM UserLikes WHERE review_id = Review._id) as like_num, ".
        "(SELECT COUNT(_id) FROM Comment WHERE review_id = Review._id) as comment_num, write_date, modify_date, ".
        "(SELECT COUNT(_id) FROM UserLikes WHERE UserLikes.user_id = $user_id && UserLikes.review_id = Review._id) as is_user_liked ".
        "FROM Review ".
        "INNER JOIN User ON User._id = Review.user_id ".
        "INNER JOIN Store On Store._id = Review.store_id ".
        "WHERE user_id = $user_id ".
        "ORDER BY write_date DESC ".
        "LIMIT $page_offset, $PAGE_SIZE ";
    $result_review = mysqli_query($conn, $sql_review) or print_sql_error_and_die($conn, $sql_review);

    $res['res'] = 1;
    $res['msg'] = 'success';
    $res['reviews'] = query_result_to_array($result_review);

    echo raw_json_encode($res);
?>

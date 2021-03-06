<?php
    include('config.php');
    include('query_func.php');

    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");
    ($sort = $_POST["sort"]) != NULL or print_error_and_die("There is no sort");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");
    if(!is_numeric($sort)) print_error_and_die("sort is not number");

    if_not_valid_store_id_then_die($store_id);

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    if(isset($_POST["user_id"])) {
        $user_id = $_POST["user_id"];

        $sql_review =
            "SELECT Review._id as review_id, Store._id as store_id, Store.name as store_name, ".
            "user_id, User.user_name, User.is_owner, star_rate, content, img1, img2, img3, ".
            "(SELECT COUNT(_id) FROM UserLikes WHERE review_id = Review._id) as like_num, ".
            "(SELECT COUNT(_id) FROM Comment WHERE review_id = Review._id) as comment_num, write_date, modify_date, ".
            "(SELECT COUNT(_id) FROM UserLikes WHERE user_id = $user_id && review_id = Review._id) AS is_user_liked ".
            "FROM Review ".
            "INNER JOIN User ON User._id = Review.user_id ".
            "INNER JOIN Store On Store._id = Review.store_id ".
            "WHERE store_id = $store_id ";
    } else {
        $sql_review =
            "SELECT Review._id as review_id, Store._id as store_id, Store.name as store_name, ".
            "user_id, User.user_name, User.is_owner, star_rate, content, img1, img2, img3, ".
            "(SELECT COUNT(_id) FROM UserLikes WHERE review_id = Review._id) as like_num, ".
            "(SELECT COUNT(_id) FROM Comment WHERE review_id = Review._id) as comment_num, write_date, modify_date, 0 AS is_user_liked ".
            "FROM Review ".
            "INNER JOIN User ON User._id = Review.user_id ".
            "INNER JOIN Store On Store._id = Review.store_id ".
            "WHERE store_id = $store_id ";
    }

    if($sort == 0)
        $sql_review .= "ORDER BY like_num DESC ";
    else if($sort == 1)
        $sql_review .= "ORDER BY write_date DESC ";
    else
        print_error_and_die("sort MUST be one of 0, 1");

    $sql_review .= "LIMIT $page_offset, $PAGE_SIZE ";
    $result_review = mysqli_query($conn, $sql_review) or print_sql_error_and_die($conn, $sql_review);

    $res['res'] = 1;
    $res['msg'] = 'success';
    $res['reviews'] = query_result_to_array($result_review);

    echo raw_json_encode($res);
?>

<?php
    include('config.php');

    $store_id = $_POST["store_id"] or print_error_and_die("There is no store_id");
    $page = $_POST["page"] or print_error_and_die("There is no page");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql_review =
        "SELECT Store._id as store_id, Store.name as store_name, ".
        "(SELECT IFNULL(AVG(star_rate), 0) FROM Review WHERE store_id = Store._id) as star_average, ".
        "(SELECT COUNT(_id) FROM Review WHERE store_id = Store._id) as review_num, ".
        "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = Store._id) as dibs_num, ".
        "user_id, User.user_name, User.is_owner, star_rate, content, img1, img2, img3, ".
        "(SELECT COUNT(_id) FROM UserLikes WHERE review_id = Review._id) as like_num, ".
        "(SELECT COUNT(_id) FROM Comment WHERE review_id = Review._id) as comment_num, write_date, modify_date ".
        "FROM Review ".
        "INNER JOIN Store ON Store._id = Review.store_id ".
        "INNER JOIN User ON User._id = Review.user_id ".
        "WHERE store_id = $store_id ".
        "ORDER BY write_date DESC ".
        "LIMIT $page_offset, $PAGE_SIZE";
    $result_review = mysqli_query($conn, $sql_review) or print_sql_error_and_die($conn, $sql_review);

    if($result_review == null || mysqli_num_rows($result_review) == 0)
        print_error_and_die("There is no store whose id is ".$store_id);

    $res['res'] = 1;
    $res['msg'] = 'success';
    $res['reviews'] = query_result_to_array($result_review);

    echo raw_json_encode($res);
?>

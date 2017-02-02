<?php
    include('config.php');

    ($sort = $_POST["sort"]) != NULL or print_error_and_die("There is no sort");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($sort)) print_error_and_die("sort is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    $page_offset = $PAGE_SIZE * ($page - 1);

    $now = new DateTime();
    $now->sub(new DateInterval("P7D"));
    $now_str = $now->format("Y-m-d H:i:s");

    $sql_review =
        "SELECT Review._id as review_id, Store._id as store_id, Store.name as store_name, ".
        "(SELECT IFNULL(AVG(star_rate), 0) FROM Review WHERE store_id = Store._id) as star_average, ".
        "(SELECT COUNT(_id) FROM Review WHERE store_id = Store._id) as review_num, ".
        "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = Store._id) as dibs_num, ".
        "user_id, User.user_name, User.is_owner, star_rate, content, img1, img2, img3, ".
        "(SELECT COUNT(_id) FROM UserLikes WHERE review_id = Review._id) as like_num, ".
        "(SELECT COUNT(_id) FROM Comment WHERE review_id = Review._id) as comment_num, write_date, modify_date ".
        "FROM Review ".
        "INNER JOIN Store ON Store._id = Review.store_id ".
        "INNER JOIN User ON User._id = Review.user_id ";

    if($sort == 0)
        $sql_review .= "WHERE write_date >= '$now_str' ORDER BY like_num DESC ";
    else if($sort == 1)
        $sql_review .= "ORDER BY write_date DESC ";
    else if($sort == 2)
        $sql_review .= "ORDER BY like_num DESC ";
    else
        print_error_and_die("sort MUST be one of 0, 1, 2");

    $result_review = mysqli_query($conn, $sql_review) or print_error_and_die(mysqli_error($conn));

    $res['res'] = 1;
    $res['msg'] = 'success';
    $res['reviews'] = query_result_to_array($result_review);

    echo raw_json_encode($res);
?>
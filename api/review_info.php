<?php
    include('config.php');
    include('query_func.php');

    ($review_id = $_POST["review_id"]) != NULL or print_error_and_die("There is no review_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($review_id)) print_error_and_die("review_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    if_not_valid_user_id_then_die($user_id);

    $sql_review =
        "SELECT Store._id as store_id, Store.name as store_name, ".
        "user_id, User.user_name, User.is_owner, star_rate, content, img1, img2, img3, ".
        "(SELECT COUNT(_id) FROM UserLikes WHERE review_id = Review._id) as like_num, ".
        "(SELECT COUNT(_id) FROM Comment WHERE review_id = Review._id) as comment_num, write_date, modify_date, ".
        "(SELECT IF(COUNT(_id) > 0, 1, 0) FROM UserLikes WHERE user_id = $user_id AND review_id = Review._id) as is_user_liked ".
        "FROM Review ".
        "INNER JOIN Store ON Store._id = Review.store_id ".
        "INNER JOIN User ON User._id = Review.user_id ".
        "WHERE Review._id = $review_id ";
    $result_review = mysqli_query($conn, $sql_review) or print_sql_error_and_die($conn, $sql_review);

    if($result_review == null || mysqli_num_rows($result_review) == 0)
        print_error_and_die("There is no review whose id is ".$review_id);

    $sql_comment =
        "SELECT Comment._id as comment_id, user_id, User.user_name, User.is_owner, content, date ".
        "FROM Comment ".
        "INNER JOIN User ON User._id = Comment.user_id ".
        "WHERE review_id = $review_id";
    $result_comment = mysqli_query($conn, $sql_comment) or print_error_and_die(mysqli_error($conn));

    $res = mysqli_fetch_assoc($result_review);
    $res["data"] = query_result_to_array($result_comment);
    $res = array('res' => 1, 'msg' => 'success') + $res;

    echo raw_json_encode($res);

    $sql_views = "UPDATE Review SET views = views + 1 WHERE _id = $review_id";
    mysqli_query($conn, $sql_views)
?>

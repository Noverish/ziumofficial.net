<?php
    include('config.php');
    include('query_func.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    if_not_valid_user_id_then_die($user_id);

    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql =
        "SELECT Store._id as store_id, Store.name as store_name, ".
        "(SELECT ROUND(IFNULL(AVG(star_rate), 0), 1) FROM Review WHERE store_id = Store._id) as star_average, ".
        "(SELECT COUNT(_id) FROM Review WHERE store_id = Store._id) as review_num, ".
        "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = Store._id) as dibs_num, ".
        "Store.img as store_img, Store.is_new, ".
        "(SELECT IF(COUNT(_id) = 0, 0, 1) FROM Event WHERE store_id = Store._id) as is_event, date as dib_date ".
        "FROM UserDibs ".
        "INNER JOIN Store ON UserDibs.store_id = Store._id ".
        "WHERE UserDibs.user_id = $user_id ".
        "LIMIT $page_offset, $PAGE_SIZE ";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $keyword));
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = query_result_to_array($result);

    echo raw_json_encode($res);
?>

<?php
    include('config.php');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "NULL";
    ($category = $_POST["category"]) != NULL or print_error_and_die("There is no category");
    ($region = $_POST["region"]) != NULL or print_error_and_die("There is no region");
    ($type1 = $_POST["type1"]) != NULL or print_error_and_die("There is no type1");
    ($type2 = $_POST["type2"]) != NULL or print_error_and_die("There is no type2");
    ($sort = $_POST["sort"]) != NULL or print_error_and_die("There is no sort");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    if(!is_numeric($category)) print_error_and_die("category is not number");
    if(!is_numeric($region)) print_error_and_die("region is not number");
    if(!is_numeric($type1)) print_error_and_die("type1 is not number");
    if(!is_numeric($type2)) print_error_and_die("type2 is not number");
    if(!is_numeric($sort)) print_error_and_die("sort is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql =
        "SELECT _id as store_id, name as store_name, ".
        "(SELECT ROUND(IFNULL(AVG(star_rate), 0), 1) FROM Review WHERE store_id = Store._id) as star_average, ".
        "(SELECT COUNT(_id) FROM Review WHERE store_id = Store._id) as review_num, ".
        "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = Store._id) as dibs_num, ".
        "img as store_img, is_new, ".
        "(SELECT IF(COUNT(_id) = 0, 0, 1) FROM Event WHERE store_id = Store._id) as is_event ".
        "FROM Store ".
        "WHERE (category & $category != 0) AND (region & $region != 0) AND (type1 & $type1 != 0) AND (type2 & $type2 != 0) ";

    if($sort == 0)
        $sql .= "ORDER BY (views + dibs_num * 30 + star_average * review_num * 10) DESC ";
    else if($sort == 1)
        $sql .= "ORDER BY star_average DESC ";
    else if($sort == 2)
        $sql .= "ORDER BY review_num DESC ";
    else
        print_error_and_die("sort MUST be one of 0, 1, 2");

    $sql .= "LIMIT $page_offset, $PAGE_SIZE ";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = query_result_to_array($result);

    echo raw_json_encode($res);

    $history = "INSERT INTO HistorySearchOption (user_id, category, region, type1, type2, date, is_android, app_version) VALUES ($user_id, $category, $region, $type1, $type2, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $history);
?>

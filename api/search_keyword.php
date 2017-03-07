<?php
    include('config.php');

    ($keyword = $_POST["keyword"]) != NULL or print_error_and_die("There is no keyword");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($page)) print_error_and_die("page is not number");

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    $keyword = str_replace(" ","",$keyword);

    $value = 0;
    if(strpos($keyword, "배달") !== false) $value += pow(2, 0);
    if(strpos($keyword, "포장") !== false) $value += pow(2, 1);
    if(strpos($keyword, "예약") !== false) $value += pow(2, 3) + pow(2, 9);
    if(strpos($keyword, "대관") !== false) $value += pow(2, 4);
    if(strpos($keyword, "단체석") !== false) $value += pow(2, 5) + pow(2, 10);
    if(strpos($keyword, "좌식") !== false) $value += pow(2, 6);
    if(strpos($keyword, "흡연실") !== false) $value += pow(2, 7);
    if(strpos($keyword, "1인석") !== false) $value += pow(2, 8);

    $sql =
        "SELECT ViewStorePreview.* FROM StoreKeyword ".
        "INNER JOIN ViewStorePreview ON ViewStorePreview.store_id = StoreKeyword.store_id ".
        "WHERE REPLACE(keyword, ' ', '') LIKE '%%%s%%' ".
        "UNION ".
        "SELECT * FROM ViewStorePreview ".
        "WHERE REPLACE(store_name, ' ', '') LIKE '%%%s%%' ".
        "UNION ".
        "SELECT ViewStorePreview.* FROM Store ".
        "INNER JOIN ViewStorePreview ON ViewStorePreview.store_id = Store._id ".
        "WHERE (property & $value != 0) ".
        "LIMIT $page_offset, $PAGE_SIZE ";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $keyword),
        mysqli_real_escape_string($conn, $keyword));
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = query_result_to_array($result);

    echo raw_json_encode($res);

    $escape_keyword = mysqli_real_escape_string($conn, $keyword);

    $history = "INSERT INTO HistorySearchKeyword (user_id, keyword, date) VALUES (1, '$escape_keyword', now())";
    $result = mysqli_query($conn, $history);
?>

<?php
    include('config.php');
    include('query_func.php');

    $category = $_POST["category"];
    $region = $_POST["region"];
    $type1 = $_POST["type1"];
    $type2 = $_POST["type2"];
    $sort = $_POST["sort"];
    $page = $_POST["page"];

    $sql="SELECT * FROM Store WHERE (category & $category = $category) AND (region & $region = $region) AND (type1 & $type1 = $type1) AND (type2 & $type2 = $type2)";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $stores = get_store_array($result);

    if ($sort == 0) {
        $popular = array();
        foreach ($stores as $key => $row)
            $popular[$key] = $row['views'] + ($row['dibs_num'] * 30) + ($row['star_average'] * $row['review_num'] * 5);
        array_multisort($popular, SORT_DESC, $stores);
    } else if ($sort == 1) {
        $star_average = array();
        foreach ($stores as $key => $row)
            $star_average[$key] = $row['star_average'];
        array_multisort($star_average, SORT_DESC, $stores);
    } else if ($sort == 2) {
        $review = array();
        foreach ($stores as $key => $row)
            $review[$key] = $row['review_num'];
        array_multisort($review, SORT_DESC, $stores);
    }

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = array_slice($stores,$PAGE_SIZE * ($page - 1),$PAGE_SIZE);

    echo raw_json_encode($res);
?>

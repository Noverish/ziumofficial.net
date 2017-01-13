<?php
    include('config.php');
    include('module_store.php');

    $category = $_POST["category"];
    $region = $_POST["region"];
    $type1 = $_POST["type1"];
    $type2 = $_POST["type2"];
    $sort = $_POST["sort"];
    $page = $_POST["page"];

    $sql="SELECT _id FROM Store WHERE (category & $category = $category) AND (region & $region = $region) AND (type1 & $type1 = $type1) AND (type2 & $type2 = $type2)";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    $stores = get_store_array($result);

    $star_rate = array();
    foreach ($stores as $key => $row)
    {
        $star_rate[$key] = $row['star_average'];
    }
    array_multisort($star_rate, SORT_DESC, $stores);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["stores"] = array_slice($stores,$PAGE_SIZE * ($page - 1),$PAGE_SIZE);

    echo raw_json_encode($res);
?>

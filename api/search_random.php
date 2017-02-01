<?php
    include('config.php');

    $category = $_POST["category"] or print_error_and_die("There is no category");
    $region = $_POST["region"] or print_error_and_die("There is no region");
    $type1 = $_POST["type1"] or print_error_and_die("There is no type1");
    $type2 = $_POST["type2"] or print_error_and_die("There is no type2");

    if(!is_numeric($category)) print_error_and_die("category is not number");
    if(!is_numeric($region)) print_error_and_die("region is not number");
    if(!is_numeric($type1)) print_error_and_die("type1 is not number");
    if(!is_numeric($type2)) print_error_and_die("type2 is not number");

    $sql="SELECT _id as store_id FROM Store WHERE (category & $category != 0) AND (region & $region != 0) AND (type1 & $type1 != 0) AND (type2 & $type2 != 0)";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);
?>

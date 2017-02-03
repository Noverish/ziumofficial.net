<?php
    include('config.php');

    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");

    $sql =
        "SELECT _id as store_id, name as store_name, ".
        "(SELECT ROUND(IFNULL(AVG(star_rate), 0), 1) FROM Review WHERE store_id = Store._id) as star_average, ".
        "(SELECT COUNT(_id) FROM Review WHERE store_id = Store._id) as review_num, ".
        "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = Store._id) as dibs_num, ".
        "img as store_img, is_new, ".
        "(SELECT IF(COUNT(_id) = 0, 0, 1) FROM Event WHERE store_id = Store._id) as is_event ".
        "FROM Store ".
        "WHERE _id = $store_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    if($result == null || mysqli_num_rows($result) == 0)
        print_error_and_die("There is no store whose id is ".$store_id);

    $res = array('res' => 1, 'msg' => 'success') + mysqli_fetch_assoc($result);

    echo raw_json_encode($res);
?>

<?php
    include('config.php');

    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    $sql_store = "SELECT *, ".
                 "(SELECT img_main FROM Event WHERE store_id = $store_id AND is_open = 1) as event_main, ".
                 "(SELECT img_detail FROM Event WHERE store_id = $store_id AND is_open = 1) as event_detail, ".
                 "(SELECT ROUND(IFNULL(AVG(star_rate), 0), 1) FROM Review WHERE store_id = $store_id) as star_average, ".
                 "(SELECT COUNT(_id) FROM Review WHERE store_id = $store_id) as review_num,".
                 "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = $store_id) as dibs_num, ".
                 "(SELECT IF(COUNT(_id) > 0, 1, 0) FROM UserDibs WHERE user_id = $user_id AND store_id = Store._id) as is_user_dib ".
                 "FROM Store ".
                 "WHERE Store._id = $store_id";
    $result_store = mysqli_query($conn, $sql_store) or print_sql_error_and_die($conn, $sql_store);
    $res = mysqli_fetch_assoc($result_store);

    if($result_store == null || mysqli_num_rows($result_store) == 0)
        print_error_and_die("There is no store whose id is ".$store_id);

    $sql_img = "SELECT * FROM StoreImage WHERE store_id = $store_id ORDER BY priority DESC";
    $result_img = mysqli_query($conn, $sql_img) or print_sql_error_and_die($conn, $sql_img);
    $imgs = array();
    $menus = array();
    while($row_img = mysqli_fetch_assoc($result_img)) {
        if($row_img['is_menu'])
            $menus[] = $row_img['img'];
        else
            $imgs[] = $row_img['img'];
    }
    $res['imgs'] = $imgs;
    $res['menus'] = $menus;

    unset($res["_id"]);
    unset($res["img"]);
    unset($res["views"]);

    $res = array('res' => 1, 'msg' => 'success') + $res;

    echo raw_json_encode($res);

    $sql_views = "UPDATE Store SET views = views + 1 WHERE _id = $store_id";
    mysqli_query($conn, $sql_views);

    $sql = "INSERT INTO HistoryStore (user_id, store_id, date, is_android, app_version) VALUES ($user_id, $store_id, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);
?>

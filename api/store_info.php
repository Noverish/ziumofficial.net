<?php
    include('config.php');

    $store_id = $_POST["store_id"] or print_error_and_die("There is no store_id");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");

    $sql_store = "SELECT *, Event.img_main, Event.img_detail, ".
                 "(SELECT AVG(star_rate) FROM Review WHERE store_id = $store_id) as star_average, ".
                 "(SELECT COUNT(_id) FROM Review WHERE store_id = $store_id) as review_num,".
                 "(SELECT COUNT(_id) FROM UserDibs WHERE store_id = $store_id) as dibs_num ".
                 "FROM Store ".
                 "INNER JOIN Event ON Store._id = Event.store_id ".
                 "WHERE Store._id = $store_id";
    $result_store = mysqli_query($conn, $sql_store) or print_sql_error_and_die($conn, $sql_store);
    $res = mysqli_fetch_assoc($result_store);

    if($result == null || mysqli_num_rows($res) == 0)
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
?>

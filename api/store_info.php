<?php
    include('config.php');
    include('query_func.php');

    $store_id = $_POST["store_id"];



    $sql_store = "SELECT * FROM Store WHERE _id = $store_id";
    $result_store = mysqli_query($conn, $sql_store) or print_error_and_die(mysqli_error($conn));
    $tmp = query_result_to_array($result_store);
    $res = $tmp[0];

    $array_review = get_star_average_and_review_num($store_id);
    $res["star_average"] = $array_review["star_average"];
    $res["review_num"] = $array_review["review_num"];

    $res["dibs_num"] = get_dibs_num($store_id);

    $sql_img = "SELECT * FROM StoreImage WHERE store_id = $store_id ORDER BY priority DESC";
    $result_img = mysqli_query($conn, $sql_img) or print_error_and_die(mysqli_error($conn));
    $imgs = array();
    $menus = array();
    while($row_img = mysqli_fetch_assoc($result_img)) {
        if($row_img['is_menu']) {
            $menu['menu'] = $row_img['img'];
            $menus[] = $menu;
        } else {
            $img['img'] = $row_img['img'];
            $imgs[] = $img;
        }
    }
    $res['imgs'] = $imgs;
    $res['menus'] = $menus;

    unset($res["_id"]);
    unset($res["img"]);
    unset($res["views"]);

    $res = array_merge(array('res' => 1, 'msg' => 'success'), $res);

    echo raw_json_encode($res);
?>

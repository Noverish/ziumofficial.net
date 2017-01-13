<?php
    include('config.php');

    $store_id = $_POST["store_id"];

    $sql_store = "SELECT * FROM Store WHERE _id = $store_id";
    $result_store = mysqli_query($conn, $sql_store) or print_error_and_die(mysqli_error($conn));
    $tmp = query_result_to_array($result_store);
    $data = $tmp[0];

    $sql_review = "SELECT star_rate FROM Review WHERE store_id = $store_id";
    $result_review = mysqli_query($conn, $sql_review) or print_error_and_die(mysqli_error($conn));
    while($row_review = mysqli_fetch_assoc($result_review))
        $total_star += $row_review["star_rate"];
    $data["review_num"] = mysqli_num_rows($result_review);
    if($data["review_num"] > 0)
        $data["star_average"] = $total_star / $data["review_num"];
    else
        $data["star_average"] = 0;

    $sql_dib = "SELECT COUNT(*) FROM UserDibs WHERE store_id = $store_id";
    $result_dib = mysqli_query($conn, $sql_dib) or print_error_and_die(mysqli_error($conn));
    $row_dib = mysqli_fetch_array($result_dib);
    $data["dibs_num"] = $row_dib[0];

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
    $data['imgs'] = $imgs;
    $data['menus'] = $menus;

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"];

    echo raw_json_encode($res);
?>

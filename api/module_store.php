<?php
    include_once('config.php');

    function get_store_array($result_id) {
        global $conn;
        $stores = array();

        while($row = mysqli_fetch_assoc($result_id)) {
            $store_id = $row["_id"];
            $store["store_id"] = $store_id;

            $sql_store = "SELECT name, is_new, event_id, img FROM Store WHERE _id = $store_id";
            $result_store = mysqli_query($conn, $sql_store) or print_error_and_die(mysqli_error($conn));
            $row_store = mysqli_fetch_array($result_store);
            $store["store_name"] = $row_store["name"];

            $sql_review = "SELECT star_rate FROM Review WHERE store_id = $store_id";
            $result_review = mysqli_query($conn, $sql_review) or print_error_and_die(mysqli_error($conn));
            while($row_review = mysqli_fetch_assoc($result_review))
                $total_star += $row_review["star_rate"];
            $store["review_num"] = mysqli_num_rows($result_review);
            if($store["review_num"] > 0)
                $store["star_average"] = $total_star / $store["review_num"];
            else
                $store["star_average"] = 0;

            $sql_dib = "SELECT COUNT(*) FROM UserDibs WHERE store_id = $store_id";
            $result_dib = mysqli_query($conn, $sql_dib) or print_error_and_die(mysqli_error($conn));
            $row_dib = mysqli_fetch_array($result_dib);
            $store["dibs_num"] = $row_dib[0];

            $store["store_img"] = $row_store["img"];
            $store["is_new"] = $row_store["is_new"];
            $store["is_event"] = $row_Store["event_id"] != null;

            $stores[] = $store;
        }

        return $stores;
    }
?>

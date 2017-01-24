<?php
    include_once('config.php');

    function get_star_average_and_review_num($store_id) {
        global $conn;

        $sql = "SELECT star_rate FROM Review WHERE store_id = $store_id";
        $result = mysqli_query($conn, $sql) or print_error_and_die($sql);
        $array["review_num"] = mysqli_num_rows($result);

        if($array["review_num"] > 0) {
            while($row = mysqli_fetch_assoc($result))
                $total_star += $row["star_rate"];

            $array["star_average"] = $total_star / $array["review_num"];
        } else {
            $array["star_average"] = 0;
        }

        return $array;
    }

    function get_dibs_num($store_id) {
        global $conn;
        $sql = "SELECT COUNT(*) FROM UserDibs WHERE store_id = $store_id";
        $result = mysqli_query($conn, $sql) or print_error_and_die($sql);
        $row = mysqli_fetch_array($result);
        return (int) $row[0];
    }

    function get_store_name($store_id) {
        global $conn;
        $sql = "SELECT name FROM Store WHERE _id = $store_id";
        $result = mysqli_query($conn, $sql) or print_error_and_die($sql);
        $row = mysqli_fetch_assoc($result);
        return $row["name"];
    }

    function get_user_name_and_is_owner($user_id) {
        global $conn;
        $sql = "SELECT user_name, is_owner FROM User WHERE _id = $user_id";
        $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($result);
        $array["user_name"] = $row["user_name"];
        $array["is_owner"] = $row["is_owner"];
        return $array;
    }

    function get_like_num($review_id) {
        global $conn;
        $sql = "SELECT COUNT(*) FROM UserLikes WHERE review_id = $review_id";
        $result = mysqli_query($conn, $sql) or print_error_and_die($sql);
        $row = mysqli_fetch_array($result);
        return (int) $row[0];
    }

    function get_comment_num($review_id) {
        global $conn;
        $sql = "SELECT COUNT(*) FROM Comment WHERE review_id = $review_id";
        $result = mysqli_query($conn, $sql) or print_error_and_die($sql);
        $row = mysqli_fetch_array($result);
        return (int) $row[0];
    }

    function get_store_array($result_store) {
        global $conn;
        $stores = array();

        while($row = mysqli_fetch_assoc($result_store)) {
            $store["store_id"] = $row["_id"];
            $store["store_name"] = $row["name"];

            $array_review = get_star_average_and_review_num($store["store_id"]);
            $store["star_average"] = $array_review["star_average"];
            $store["review_num"] = $array_review["review_num"];

            $store["dibs_num"] = get_dibs_num($store["store_id"]);
            $store["store_img"] = $row["img"];
            $store["is_new"] = $row["is_new"] != 0;
            $store["is_event"] = $row["event_id"] != null;
            $store["views"] = $row["views"];

            $stores[] = $store;
        }

        return $stores;
    }

    function get_review_array($result_review) {
        global $conn;
        $reviews = array();

        while($row = mysqli_fetch_assoc($result_review)) {
            $reviews[] = add_review_extra_data($row);
        }

        return $reviews;
    }

    function add_review_extra_data($row) {
        $review["store_id"] = $row["store_id"];
        $review["store_name"] = get_store_name($review["store_id"]);

        $array_review = get_star_average_and_review_num($review["store_id"]);
        $review["star_average"] = $array_review["star_average"];
        $review["review_num"] = $array_review["review_num"];

        $review["dibs_num"] = get_dibs_num($review["store_id"]);
        $review["user_id"] = $row["user_id"];

        $array_user = get_user_name_and_is_owner($review["user_id"]);
        $review["user_name"] = $array_user["user_name"];
        $review["is_owner"] = $array_user["is_owner"] != 0;

        $review["star_rate"] = $row["star_rate"];
        $review["content"] = $row["content"];
        $review["img1"] = $row["img1"];
        $review["img2"] = $row["img2"];
        $review["img3"] = $row["img3"];

        if(array_key_exists("like_num", $row))
            $review["like_num"] = $row["like_num"];
        else
            $review["like_num"] = get_like_num($row["_id"]);

        $review["comment_num"] = get_comment_num($row["_id"]);
        $review["write_date"] = $row["write_date"];
        $review["modify_date"] = $row["modify_date"];

        return $review;
    }
?>

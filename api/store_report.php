<?php
    include('config.php');

    $store_id = $_POST["store_id"] or print_error_and_die("There is no store_id");
    $user_id = $_POST["user_id"] or print_error_and_die("There is no user_id");
    $content = $_POST["content"] or print_error_and_die("There is no content");

    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");
    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    $sql_store = "SELECT _id FROM Store WHERE _id = $store_id";
    $result_store = mysqli_query($conn, $sql_store) or print_sql_error_and_die($conn, $sql_store);
    if($result_store == null || mysqli_num_rows($result_store) == 0)
        print_error_and_die("There is no store whose id is ".$store_id);

    $sql_user = "SELECT _id FROM User WHERE _id = $user_id";
    $result_user = mysqli_query($conn, $sql_user) or print_sql_error_and_die($conn, $sql_user);
    if($result_user == null || mysqli_num_rows($result_user) == 0)
        print_error_and_die("There is no user whose id is ".$user_id);

    $sql = "INSERT INTO StoreReport (user_id, store_id, content, date) VALUES ($user_id, $store_id, '%s', now())";
    $sql = sprintf($sql,
        mysqli_real_escape_string($conn, $content));
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

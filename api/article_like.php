<?php
    include('config.php');
    include('query_func.php');

    ($article_id = $_POST["article_id"]) != NULL or print_error_and_die("There is no article_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    $sql = "SELECT _id, date FROM ArticleLike WHERE user_id = $user_id AND article_id = $article_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    if(mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO ArticleLike (user_id, article_id, date) VALUES ($user_id, $article_id, now())";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 1;
    } else {
        $sql = "DELETE FROM ArticleLike WHERE user_id = $user_id AND article_id = $article_id";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
        $res["is_user_liked"] = 0;
    }

    echo raw_json_encode($res);
?>

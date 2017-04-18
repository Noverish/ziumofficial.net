<?php
    include('config.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($article_id = $_POST["article_id"]) != NULL or print_error_and_die("There is no article_id");
    $is_android = isset($_POST['is_android']) ? "'".$_POST['is_android']."'" : "NULL";
    $app_version = isset($_POST['app_version']) ? "'".$_POST['app_version']."'" : "NULL";

    if(!is_numeric($article_id)) print_error_and_die("article_id is not number");

    $sql="SELECT *, (SELECT COUNT(*) FROM ArticleLike WHERE user_id = $user_id && article_id = ViewArticle.article_id) AS is_user_liked FROM ViewArticle WHERE article_id = $article_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $row["res"] = 1;
    $row["msg"] = "success";

    echo raw_json_encode($row);

    $sql = "UPDATE Article SET views = views + 1 WHERE _id = $article_id";
    $result = mysqli_query($conn, $sql);

    $sql = "INSERT INTO HistoryArticle (article_id, user_id, date, is_android, app_version) VALUES ($article_id, $user_id, now(), $is_android, $app_version)";
    $result = mysqli_query($conn, $sql);
?>

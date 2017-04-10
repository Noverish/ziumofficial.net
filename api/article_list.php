<?php
    include('config.php');

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");
    ($page = $_POST["page"]) != NULL or print_error_and_die("There is no page");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($page)) print_error_and_die("page is not number");

    if($page < 1) print_error_and_die("page must be bigger than 0");
    $page_offset = $PAGE_SIZE * ($page - 1);

    $sql="SELECT *, ".
         "(SELECT COUNT(*) FROM ArticleLike WHERE user_id = $user_id && article_id = ViewArticle.article_id) AS is_user_liked ".
         "FROM ViewArticle ".
         "ORDER BY article_id DESC ".
         "LIMIT $page_offset, $PAGE_SIZE";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = query_result_to_array($result);

    echo raw_json_encode($res);

    /*CREATE VIEW ViewArticle AS SELECT
    Article._id as article_id,
    ArticleWriter.profile_img as writer_profile,
    ArticleWriter.name as writer_name,
    ArticleWriter.detail as writer_detail,
    title,
    img,
    url,
    (SELECT COUNT(_id) FROM ArticleLike WHERE article_id = Article._id) as like_num
    FROM Article
    INNER JOIN ArticleWriter ON writer_id = ArticleWriter._id
    */
?>

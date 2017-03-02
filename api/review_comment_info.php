<?php
    include('config.php');
    include('query_func.php');

    ($comment_id = $_POST["comment_id"]) != NULL or print_error_and_die("There is no comment_id");

    if(!is_numeric($comment_id)) print_error_and_die("comment_id is not number");

    $sql=
        "SELECT review_id, Comment._id as comment_id, user_id, User.user_name, User.is_owner, content, date ".
        "FROM Comment ".
        "INNER JOIN User ON User._id = Comment.user_id ".
        "WHERE Comment._id = $comment_id ";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    $res = mysqli_fetch_assoc($result);

    $res = array('res' => 1, 'msg' => 'success') + $res;

    echo raw_json_encode($res);
?>

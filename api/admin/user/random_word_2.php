<?php
    include('../../config.php');
    header('Content-type:text/html;charset=utf-8');

    ($word = $_POST["word"]) != NULL or print_error_and_die("There is no word");
    ($key = $_POST["key"]) != NULL or print_error_and_die("There is no key");

    if(strcmp($key, "1415926") != 0)
        print_error_and_die("Wrong Key");

    $word_escape = mysqli_real_escape_string($conn, $word);

    $sql="INSERT INTO RandomWord2 (word) VALUES ('$word_escape')";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";

    echo raw_json_encode($res);
?>

<?php
    include('../../config.php');
    header('Content-type:text/html;charset=utf-8');

    ($user_name = $_POST["user_name"]) != NULL or print_error_and_die("There is no user_name");
    ($content = $_POST["content"]) != NULL or print_error_and_die("There is no content");
    ($key = $_POST["key"]) != NULL or print_error_and_die("There is no key");

    if(strcmp($key, "3.1415926") != 0)
        print_error_and_die("Wrong Key");

    $user_name_escape = mysqli_real_escape_string($conn, $user_name);
    $content_escape = mysqli_real_escape_string($conn, $content);

    $sql="INSERT INTO UserMsg ".
         "(user_id, is_user_sent, is_user_read, content, date) VALUES ".
         "((SELECT _id FROM User WHERE user_name='$user_name_escape'), 0, 0, '$content_escape', now()) ";
    $result = mysqli_query($conn, $sql);
    if($result) {
        $res["res"] = 1;
        $res["msg"] = "success";
    } else {
        $res["res"] = 0;
        $res["msg"] = "There is no user whose name is $user_name";
    }

    echo raw_json_encode($res);
?>

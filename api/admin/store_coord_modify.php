<?php
    include('../config.php');
    include('../query_func.php');

    ($name = $_POST["name"]) != NULL or print_error_and_die("There is no name");
    ($lat = $_POST["lat"]) != NULL or print_error_and_die("There is no lat");
    ($lng = $_POST["lng"]) != NULL or print_error_and_die("There is no lng");
    ($key = $_POST["key"]) != NULL or print_error_and_die("There is no key");

    if(!is_numeric($lat)) print_error_and_die("lat is not number");
    if(!is_numeric($lng)) print_error_and_die("lng is not number");
    if(!is_numeric($key)) print_error_and_die("key is not number");

    if($key != 1415926)
        print_error_and_die("key is wrong");

    $name_escape = mysqli_real_escape_string($conn, $name);

    $sql = "UPDATE Store SET lat = '$lat', lng = '$lng' WHERE name = '$name_escape'";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));

    if(mysqli_affected_rows($conn) > 0) {
        $res["res"] = 1;
        $res["msg"] = "success";
    } else {
        $res["res"] = 0;
        $res["msg"] = "There is no store whose name is $name OR Nothing is changed";
    }

    echo raw_json_encode($res);
?>

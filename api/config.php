<?php
    $mysqli_hostname = 'db.ziumcompany.net';
    $mysqli_user = 'ziumofficial';
    $mysqli_password = 'zntbffod1!';
    $mysqli_database = 'dbziumofficial';

    $conn = mysqli_connect($mysqli_hostname, $mysqli_user, $mysqli_password, $mysqli_database) or die("db connect error");

    mysqli_query($conn,"set session character_set_connection=utf8;");
    mysqli_query($conn,"set session character_set_results=utf8;");
    mysqli_query($conn,"set session character_set_client=utf8;");

    function print_error_and_die($msg) {
        $response["res"] = 0;
        $response["msg"] = $msg;
        die(json_encode($response));
    }
?>

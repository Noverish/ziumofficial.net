<?php
    $mysqli_hostname = 'db.ziumcompany.net';
    $mysqli_user = 'ziumofficial';
    $mysqli_password = 'zntbffod1!';
    $mysqli_database = 'dbziumofficial';

    $bd = mysqli_connect($mysqli_hostname, $mysqli_user, $mysqli_password, $mysqli_database) or die("db connect error");

    mysqli_query("set session character_set_connection=utf8;");
    mysqli_query("set session character_set_results=utf8;");
    mysqli_query("set session character_set_client=utf8;");
?>

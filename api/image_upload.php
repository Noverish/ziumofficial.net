<?php
    include('config.php');
    $path = "../asset/image/";

    ($base = $_POST["image"]) != NULL or print_error_and_die("There is no image");
    ($store_id = $_POST["store_id"]) != NULL or print_error_and_die("There is no store_id");
    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");
    if(!is_numeric($store_id)) print_error_and_die("store_id is not number");

    $user_str = sprintf("%08dU",$user_id);
    $store_str = sprintf("%04dS",$store_id);
    $millis = round(microtime(true) * 1000);
    $random_str = random_string($base);

    $filename = $store_str."_".$user_str."_".$millis."_".$random_str.".jpg";

    $binary = base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');

    $file = fopen($path.$filename, 'wb');

    fwrite($file, $binary);
    fclose($file);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["url"] = "http://ziumcompany.net/asset/image/".$filename;
    echo(json_encode($res));
?>

<?php
// echo(get_current_user());
// mb_internal_encoding("UTF-8");
// echo(mb_internal_encoding());
// echo exec('whoami');
// chmod("../asset/image", 0777);
    // $test = fopen("../asset/image/test.txt",'w');
    // fwrite($test,"asdf");
    // fclose($test);
    // echo("asdf");
    // $binary = file_get_contents('php://input');
    // Get image string posted from Android App
    $base = $_REQUEST['image'];
    // Get file name posted from Android App
    $folder = "../asset/image/";
    $filename = hash("sha256", substr($base,rand(0, strlen($base) - 20),16)).".jpg";
    // Decode Image
    $binary = base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');
    // Images will be saved under 'www/imgupload/uplodedimages' folder
    $file = fopen($folder.$filename, 'wb');
    // Create File
    fwrite($file, $binary);
    fclose($file);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["url"] = "http://ziumcompany.net/asset/image/".$filename;
    echo(json_encode($res));
?>

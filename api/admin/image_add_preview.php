<?php
    include("../config.php");
    require_once 'parsecsv-for-php/parsecsv.lib.php';

    header('Content-type:text/html;charset=utf-8');

    $csv = new parseCSV();
    $csv->encoding('euc-kr', 'UTF-8');
    $csv->parse('store_data.csv');

    $data = $csv->data;
    $length = count($data);

    $has_error = false;
    $sqls = array();
    for($i = 0; $i < $length; $i++) {

        $tmp = $data[$i]["상점 이름"];
        $tmp = trim($tmp);
        $name = $tmp;

        //If there is no store name, then consider this row is empty row
        if(strcmp($name, "") == 0)
            continue;

        echo(sprintf("%20s : ",$name));

        //Check this store already inserted
        $escape_name = mysqli_real_escape_string($conn, $name);
        $sql = "SELECT _id FROM Store WHERE name='$escape_name'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        if(mysqli_num_rows($result) == 0) {
            $has_error = true;
            echo("is not exists<br>");
            continue;
        }

        $store_id = $row[0];
        echo("$store_id - ");

        $files = scandir("../../asset/store/$name/");

        for($j = 2; $j < count($files); $j++) {
            $tmp = $files[$j];

            $img_split = explode("_",$tmp);
            $is_menu = (strcmp($img_split[1],"menu") == 0) ? 1 : 0;

            $img = "http://ziumcompany.net/asset/store/$name/$tmp";
            $escape_img = mysqli_real_escape_string($conn, $img);
            $sqls[] = "INSERT INTO StoreImage (store_id, is_menu, img) VALUES ($store_id, $is_menu, '$escape_img')";
        }
        echo("<br>");
    }

    foreach($sqls as &$sql) {
        echo("$sql<br>");
    }
?>

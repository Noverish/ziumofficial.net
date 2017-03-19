<?php
    if(strcmp($_POST["key"], "!@#$") != 0)
        die("invalid key");

    $categorys = $_POST["category"];
    $regions = $_POST["region"];
    $type1s = $_POST["type1"];
    $type2s = $_POST["type2"];
    $propertys = $_POST["property"];
    $property_shows = $_POST["property_show"];

    $category = 0;
    $region = 0;
    $type1 = 0;
    $type2 = 0;
    $property = 0;
    $property_show = 0;

    foreach($categorys as &$value)
        $category += pow(2, $value);

    foreach($regions as &$value)
        $region += pow(2, $value);

    foreach($type1s as &$value)
        $type1 += pow(2, $value);

    foreach($type2s as &$value)
        $type2 += pow(2, $value);

    foreach($propertys as &$value)
        $property += pow(2, $value);

    foreach($property_shows as &$value)
        $property_show += pow(2, $value);

    $_POST["category"] = $category;
    $_POST["region"] = $region;
    $_POST["type1"] = $type1;
    $_POST["type2"] = $type2;
    $_POST["property"] = $property;
    $_POST["property_show"] = $property_show;

    if(strcmp($_POST['owner_comment'], "") == 0)
        unset($_POST['owner_comment']);

    if(strcmp($_POST['contact'], "") == 0)
        unset($_POST['contact']);

    if(strcmp($_POST['addr_old'], "") == 0)
        unset($_POST['addr_old']);

    if(strcmp($_POST['addr_new'], "") == 0)
        unset($_POST['addr_new']);

    $_POST["store_hours"] = preg_replace("/[\\r]*\\n/i", "\n", $_POST["store_hours"]);

    include('store_modify.php');
?>

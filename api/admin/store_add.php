<?php
    include('../config.php');
    include('../query_func.php');

    ($name = $_POST["name"]) != NULL or print_error_and_die("There is no name");
    ($category = $_POST["category"]) != NULL or print_error_and_die("There is no category");
    ($region = $_POST["region"]) != NULL or print_error_and_die("There is no region");
    ($type1 = $_POST["type1"]) != NULL or print_error_and_die("There is no type1");
    ($type2 = $_POST["type2"]) != NULL or print_error_and_die("There is no type2");
    ($img = $_POST["img"]) != NULL or print_error_and_die("There is no img");
    ($owner_comment = $_POST["owner_comment"]) != NULL or ($owner_comment = "NULL");
    ($contact = $_POST["contact"]) != NULL or ($contact = "NULL");
    ($store_hours = $_POST["store_hours"]) != NULL or ($store_hours = "");
    ($property = $_POST["property"]) != NULL or print_error_and_die("There is no property");
    ($property_show = $_POST["property_show"]) != NULL or print_error_and_die("There is no property_show");
    ($note = $_POST["note"]) != NULL or ($note = "");
    ($lat = $_POST["lat"]) != NULL or print_error_and_die("There is no lat");
    ($lng = $_POST["lng"]) != NULL or print_error_and_die("There is no lng");
    ($addr_old = $_POST["addr_old"]) != NULL or ($addr_old = "NULL");
    ($addr_new = $_POST["addr_new"]) != NULL or ($addr_new = "NULL");

    if(!is_numeric($category)) print_error_and_die("category is not number");
    if(!is_numeric($region)) print_error_and_die("region is not number");
    if(!is_numeric($type1)) print_error_and_die("type1 is not number");
    if(!is_numeric($type2)) print_error_and_die("type2 is not number");
    if(!is_numeric($property)) print_error_and_die("property is not number");
    if(!is_numeric($property_show)) print_error_and_die("property_show is not number");
    if(!is_numeric($lat)) print_error_and_die("lat is not number");
    if(!is_numeric($lng)) print_error_and_die("lng is not number");

    $name = mysqli_real_escape_string($conn, $name);
    $img = mysqli_real_escape_string($conn, $img);
    $owner_comment = mysqli_real_escape_string($conn, $owner_comment);
    $contact = mysqli_real_escape_string($conn, $contact);
    $store_hours = mysqli_real_escape_string($conn, $store_hours);
    $note = mysqli_real_escape_string($conn, $note);
    $addr_old = mysqli_real_escape_string($conn, $addr_old);
    $addr_new = mysqli_real_escape_string($conn, $addr_new);

    if(strcmp($owner_comment,"NULL") != 0) $owner_comment = "'$owner_comment'";
    if(strcmp($contact,"NULL") != 0) $contact = "'$contact'";
    if(strcmp($addr_old,"NULL") != 0) $addr_old = "'$addr_old'";
    if(strcmp($addr_new,"NULL") != 0) $addr_new = "'$addr_new'";

    $sql = "INSERT INTO Store (name, category, region, type1, type2, img, owner_comment, contact, store_hours, property, property_show, note, lat, lng, addr_old, addr_new, is_new, views, keyword) VALUES ".
           "('$name', $category, $region, $type1, $type2, '$img', $owner_comment, $contact, '$store_hours', $property, $property_show, '$note', $lat, $lng, $addr_old, $addr_new, 0, 0, '')";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["store_id"] = mysqli_insert_id($conn);

    echo raw_json_encode($res);
?>

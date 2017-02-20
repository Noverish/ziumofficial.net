<?php
    include("../config.php");
    include_once("addr2coord.php");
    require_once 'parsecsv-for-php/parsecsv.lib.php';

    header('Content-type:text/html;charset=utf-8');

    $addr2coord_csv = new parseCSV();
    $addr2coord_csv->encoding('euc-kr', 'UTF-8');
    $addr2coord_csv->parse('addr2coord.csv');
    $addr2coord = $addr2coord_csv->data;

    $csv = new parseCSV();
    $csv->encoding('euc-kr', 'UTF-8');
    $csv->parse('store_data.csv');

    $data = $csv->data;
    $length = count($data);

    $has_error = false;
    $sqls = array();
    for($i = 0; $i < $length; $i++) {
        $echo = false;

//STORE NAME
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
        if(mysqli_num_rows($result) > 0) {
            echo("is already inserted<br>");
            continue;
        }

//STORE CATEGORY
        $category = 0;
        $tmp = $data[$i]["대분류"];
        if(strpos($tmp, '밥') !== false) $category += pow(2,0);
        if(strpos($tmp, '카페') !== false) $category += pow(2,1);
        if(strpos($tmp, '술') !== false) $category += pow(2,2);

        //Check category is invalid value
        if($category == 0) {
            $echo = $has_error = true;
            echo("대분류 is invalid value - '$tmp', ");
        }

//STORE REGION
        $region = 0;
        $tmp = $data[$i]["지역"];
        if(strpos($tmp, '참살이') !== false) $region += pow(2,0);
        if(strpos($tmp, '정대후문') !== false) $region += pow(2,1);
        if(strpos($tmp, '이공후문') !== false) $region += pow(2,2);
        if(strpos($tmp, '교내') !== false) $region += pow(2,3);
        if(strpos($tmp, '정문') !== false) $region += pow(2,4);
        if(strpos($tmp, '법후') !== false) $region += pow(2,5);
        if(strpos($tmp, '제기동') !== false) $region += pow(2,6);
        if(strpos($tmp, '고려대') !== false) $region += pow(2,7);

        //Check region is invalid value
        if($region == 0) {
            $echo = $has_error = true;
            echo("지역 is invalid value - '$tmp', ");
        }

//STORE TYPE1
        $type1 = 0;
        $tmp = $data[$i]["분류1"];
        if(strpos($tmp, '한식') !== false) $type1 += pow(2,0);
        if(strpos($tmp, '중식') !== false) $type1 += pow(2,1);
        if(strpos($tmp, '일식') !== false) $type1 += pow(2,2);
        if(strpos($tmp, '양식') !== false) $type1 += pow(2,3);
        if(strpos($tmp, '치킨') !== false) $type1 += pow(2,4);
        if(strpos($tmp, '고기') !== false) $type1 += pow(2,5);
        if(strpos($tmp, '분식') !== false) $type1 += pow(2,6);
        if(strpos($tmp, '기타') !== false) $type1 += pow(2,7);

        if(strpos($tmp, '소주') !== false) $type1 += pow(2,8);
        if(strpos($tmp, '맥주') !== false) $type1 += pow(2,9);
        if(strpos($tmp, '막거리') !== false) $type1 += pow(2,10);
        if(strpos($tmp, '양주') !== false) $type1 += pow(2,11);
        if(strpos($tmp, '와인') !== false) $type1 += pow(2,12);
        if(strpos($tmp, '사케') !== false) $type1 += pow(2,13);

        if(strpos($tmp, '커피') !== false) $type1 += pow(2,16);
        if(strpos($tmp, '브런치') !== false) $type1 += pow(2,17);
        if(strpos($tmp, '빙과') !== false) $type1 += pow(2,18);
        if(strpos($tmp, '주스') !== false) $type1 += pow(2,19);
        if(strpos($tmp, '차') !== false) $type1 += pow(2,20);
        if(strpos($tmp, '제과') !== false) $type1 += pow(2,21);

        //Check type1 is invalid value
        if($type1 == 0) {
            $echo = $has_error = true;
            echo("분류1 is invalid value - '$tmp', ");
        }

//STORE TYPE2
        $type2 = 0;
        $tmp = $data[$i]["가격(밥)"];
        if(strpos($tmp, '부담없게') !== false) $type2 += pow(2,0);
        if(strpos($tmp, '무난보통') !== false) $type2 += pow(2,1);
        if(strpos($tmp, '작은사치') !== false) $type2 += pow(2,2);

        $tmp = $data[$i]["분위기(술)"];
        if(strpos($tmp, '조용조용') !== false) $type2 += pow(2,8);
        if(strpos($tmp, '무난보통') !== false) $type2 += pow(2,9);
        if(strpos($tmp, '시끌시끌') !== false) $type2 += pow(2,10);

        $tmp = $data[$i]["목적(카페)"];
        if(strpos($tmp, '테이크아웃') !== false) $type2 += pow(2,16);
        if(strpos($tmp, '조용히할일') !== false) $type2 += pow(2,17);
        if(strpos($tmp, '대화와만남') !== false) $type2 += pow(2,18);

        //Check type2 is invalid value
        if($type2 == 0) {
            $echo = $has_error = true;
            echo("분류2 is invalid value - '$tmp', ");
        }

//STORE IMAGE
        $tmp = $data[$i]["상점이미지"];
        $tmp = trim($tmp);
        if(preg_match("/[\\S]+[.](jpg|jpeg|png)/i", $tmp)) {
            $tmps = explode(".",$tmp);
            $real_image_name = $tmps[0];
            if(file_exists("../../asset/store/$name/$tmp")) {
                $img = "http://ziumcompany.net/asset/store/$name/$tmp";
            } else if(file_exists("../../asset/store/$name/$real_image_name.JPG")) {
                $img = "http://ziumcompany.net/asset/store/$name/$real_image_name.JPG";
            } else if(file_exists("../../asset/store/$name/$real_image_name.jpeg")) {
                $img = "http://ziumcompany.net/asset/store/$name/$real_image_name.jpeg";
            } else {
                $echo = $has_error = true;
                echo("상점이미지 is not exists in - '$name/$tmp', ");
            }
        } else {
            if(strcmp($tmp, "없음") == 0) {
                $img = "http://ziumcompany.net/asset/image/no_img.jpg";
            } else {
                $echo = $has_error = true;
                echo("상점이미지 is invalid value - '$tmp', ");
            }
        }
        $escape_img = mysqli_real_escape_string($conn, $img);

//OWNER COMMENT
        $tmp = $data[$i]["사장님 한마디"];
        $tmp = trim($tmp);
        if(strcmp($tmp, "") != 0)
            $owner_comment = "'$tmp'";
        else
            $owner_comment = "NULL";

//CONTACT
        $tmp = $data[$i]["연락처"];
        $tmp = trim($tmp);
        $tmp = str_replace("/","",$tmp);
        $tmp = str_replace("(","",$tmp);
        $tmp = str_replace(")","-",$tmp);
        if(preg_match("/[\\d]{2,3}-[\\d]{3,4}-[\\d]{4,4}/i", $tmp)) {
            $contact = "'$tmp'";
        } else {
            if(strcmp($tmp, "없음") == 0) {
                $contact = "NULL";
            } else {
                $echo = $has_error = true;
                echo("연락처 is invalid value - '$tmp', ");
            }
        }

//STORE HOURS
        $tmp = $data[$i]["운영시간"];
        $tmp = trim($tmp);
        $tmp = preg_replace("/[\\s]+\/[\\s]+/i","\\n",$tmp);
        if(strcmp($tmp, "") != 0)
            $store_hour = $tmp;
        else {
            $store_hour = "?";
        }

//PROPERTY
        $property = 0;
        $property_show = 0;
        $property_array = array(
            "배달(밥)" => 0,
            "포장(밥)" => 1,
            "예약(밥)" => 3,
            "예약(술)" => 9,
            "대관(술)" => 4,
            "단체석(술)" => 5,
            "좌식(카페)" => 6,
            "흡연실(카페)" => 7,
            "1인석(카페)" => 8,
            "단체석(카페)" => 10
        );
        foreach ($property_array as $key => $value) {
            $tmp = $data[$i][$key];
            $tmp = trim($tmp);
            if(strcmp($tmp, "") != 0) {
                $property_show += pow(2,$value);
                if(strcmp($tmp, 'O') == 0) {
                    $property += pow(2,$value);
                } else if(strcmp($tmp, 'X') == 0) {
                    $property += 0;
                } else {
                    $echo = $has_error = true;
                    echo("$key is invalid value - '$tmp', ");
                }
            }
        }

//NOTE
        $tmp = $data[$i]["특이사항"];
        $tmp = trim($tmp);
        $note = $tmp;

//ADDRESS_OLD
        $tmp = $data[$i]["지번주소"];
        $tmp = trim($tmp);
        $addr_old = $tmp;

//ADDRESS_NEW
        $tmp = $data[$i]["도로명주소"];
        $tmp = trim($tmp);
        $addr_new = $tmp;

        //check has address
        if(strcmp($addr_old,"") == 0 && strcmp($addr_new,"") == 0) {
            $echo = $has_error = true;
            echo("Address must be more than one, ");
        } else {

//LATITUDE
            for($index = 0; $index < count($addr2coord); $index++) {
                $addr2coord_name = trim($addr2coord[$index]["상점 이름"]);
                if(strcmp($addr2coord_name, $name) == 0) {
                    break;
                }
            }

            if($index != count($addr2coord)) { //if store name is in addr2coord.csv
                $addr2coord_old = trim($addr2coord[$index]["지번주소"]);
                $addr2coord_new = trim($addr2coord[$index]["도로명주소"]);
                $addr2coord_lat = trim($addr2coord[$index]["위도"]);
                $addr2coord_lng = trim($addr2coord[$index]["경도"]);

                if((strcmp($addr2coord_new, $addr_new) == 0 || strcmp($addr2coord_old, $addr_old) == 0) && strcmp($addr2coord_lat, "") != 0 && strcmp($addr2coord_lng, "") != 0) {
                    $lat = $addr2coord_lat;
                    $lng = $addr2coord_lng;
                } else {
                    $json = addr2coord((strcmp($addr_new,"") != 0) ? $addr_new : $addr_old);
                    if(isset($json["lat"])) {
                        $lat = $json["lat"];
                        $lng = $json["lng"];

                        $addr2coord_csv->data[$index]["지번주소"] = $addr_old;
                        $addr2coord_csv->data[$index]["도로명주소"] = $addr_new;
                        $addr2coord_csv->data[$index]["위도"] = $lat;
                        $addr2coord_csv->data[$index]["경도"] = $lng;
                        $addr2coord_csv->encoding('UTF-8', 'euc-kr');
                        $addr2coord_csv->save();
                        $addr2coord_csv->encoding('euc-kr', 'UTF-8');
                        echo("exists $lat $lng '$addr_old' '$addr_new', ");
                    } else {
                        $echo = $has_error = true;
                        echo("Invalid Address, ");
                    }
                }
            } else {
                $json = addr2coord((strcmp($addr_new,"") != 0) ? $addr_new : $addr_old);
                if(isset($json["lat"])) {
                    $lat = $json["lat"];
                    $lng = $json["lng"];

                    $addr2coord_csv->encoding('UTF-8', 'euc-kr');
                    $addr2coord_csv->save('addr2coord.csv', array(array($name, $lat, $lng, $addr_old, $addr_new)), true);
                    $addr2coord_csv->encoding('euc-kr', 'UTF-8');

                    echo("insert $lat $lng '$addr_old' '$addr_new', ");
                } else {
                    $echo = $has_error = true;
                    echo("Error occurred during processing address - ".$json["json"].", ");
                }
            }
        }

//CHANGE ADDRESS TO FIT QUERY
        if(strcmp($addr_old, "") != 0) {
            $addr_old = "'$addr_old'";
        } else {
            $addr_old = "NULL";
        }

        if(strcmp($addr_new, "") != 0) {
            $addr_new = "'$addr_new'";
        } else {
            $addr_new = "NULL";
        }


        $is_new = 0;
        $views = 0;

        echo("<br>");
        if(!$echo) {
            $sqls[$i] = "INSERT INTO Store (name, category, region, type1, type2, img, owner_comment, contact, store_hours, property, property_show, note, lat, lng, addr_old, addr_new, is_new, views) VALUES ('$escape_name', $category, $region, $type1, $type2, '$escape_img', $owner_comment, $contact, '$store_hour', $property, $property_show, '$note', $lat, $lng, $addr_old, $addr_new, $is_new, $views)";
        }
    }
?>

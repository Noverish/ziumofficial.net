<?php
    include("../config.php");
    require_once 'parsecsv-for-php/parsecsv.lib.php';

    header('Content-type:text/html;charset=utf-8');

    $csv = new parseCSV();
    $csv->encoding('euc-kr', 'UTF-8');
    $csv->parse('store_data.csv');

    $data = $csv->data;
    $length = count($data);

    for($i = 0; $i < $length; $i++) {
        $echo = false;

        $tmp = $data[$i]["상점 이름"];
        $tmp = trim($tmp);
        $name = $tmp;


        $category = 0;
        $tmp = $data[$i]["대분류"];
        if(strpos($tmp, '밥') !== false) $category += pow(2,0);
        if(strpos($tmp, '카페') !== false) $category += pow(2,1);
        if(strpos($tmp, '술') !== false) $category += pow(2,2);


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


        $tmp = $data[$i]["상점이미지"];
        $tmp = trim($tmp);
        if(preg_match("/[\\S]+[.](jpg|png)/i", $tmp))
            $img = "http://ziumcompany.net/asset/image/" + tmp;
        else {
            $img = "http://ziumcompany.net/asset/image/no_img.jpg";
            if(strcmp($tmp, "") != 0) {
                $echo = true;
                echo("img - ".$tmp." ");
            }
        }


        $tmp = $data[$i]["사장님 한마디"];
        $tmp = trim($tmp);
        if(strcmp($tmp, "") != 0)
            $owner_comment = "'".$tmp."'";
        else
            $owner_comment = "NULL";


        $tmp = $data[$i]["연락처"];
        $tmp = trim($tmp);
        $tmp = str_replace("/","",$tmp);
        $tmp = str_replace("(","",$tmp);
        $tmp = str_replace(")","-",$tmp);
        if(preg_match("/[\\d]{2,3}-[\\d]{3,4}-[\\d]{4,4}/i", $tmp))
            $contact = "'".$tmp."'";
        else {
            $contact = "NULL";
            if(strcmp($tmp, "") != 0 && strpos($tmp, '없음') === false) {
                $echo = true;
                echo("contact - ".$tmp." ");
            }
        }


        $tmp = $data[$i]["운영시간"];
        $tmp = trim($tmp);
        $tmp = preg_replace("/[\\s]+\/[\\s]+/i","\\n",$tmp);
        if(strcmp($tmp, "") != 0)
            $store_hour = $tmp;
        else {
            $store_hour = "?";
        }


        $property = 0;
        $property_show = 0;
        $tmp = $data[$i]["배달"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,0);
            if(strpos($tmp, 'O') !== false) $property += pow(2,0);
        }
        $tmp = $data[$i]["포장"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,1);
            if(strpos($tmp, 'O') !== false) $property += pow(2,1);
        }
        $tmp = $data[$i]["예약"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,3);
            if(strpos($tmp, 'O') !== false) $property += pow(2,3);
        }
        $tmp = $data[$i]["대관"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,4);
            if(strpos($tmp, 'O') !== false) $property += pow(2,4);
        }
        $tmp = $data[$i]["좌식"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,6);
            if(strpos($tmp, 'O') !== false) $property += pow(2,6);
        }
        $tmp = $data[$i]["흡연실"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,7);
            if(strpos($tmp, 'O') !== false) $property += pow(2,7);
        }
        $tmp = $data[$i]["1인석"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,8);
            if(strpos($tmp, 'O') !== false) $property += pow(2,8);
        }
        $tmp = $data[$i]["단체석"];
        if(strcmp($tmp, "") != 0) {
            $property_show += pow(2,5);
            if(strpos($tmp, 'O') !== false) $property += pow(2,5);
        }


        $tmp = $data[$i]["특이사항"];
        $tmp = trim($tmp);
        $note = $tmp;


        $tmp = $data[$i]["위도"];
        $tmp = trim($tmp);
        if(preg_match("/[\\d]{2,3}[.][\\d]+/i", $tmp))
            $lat = $tmp;
        else {
            $lat = "0.0";
            if(strcmp($tmp, "") != 0) {
                $echo = true;
                echo("lat - ".$tmp." ");
            }
        }


        $tmp = $data[$i]["경도"];
        $tmp = trim($tmp);
        if(preg_match("/[\\d]{2,3}[.][\\d]+/i", $tmp))
            $lng = $tmp;
        else {
            $lng = "0.0";
            if(strcmp($tmp, "") != 0) {
                $echo = true;
                echo("lng - ".$tmp." ");
            }
        }


        $tmp = $data[$i]["지번주소"];
        $tmp = trim($tmp);
        if(strcmp($tmp, "") != 0)
            $addr_old = "'".$tmp."'";
        else
            $addr_old = "NULL";


        $tmp = $data[$i]["도로명주소"];
        $tmp = trim($tmp);
        if(strcmp($tmp, "") != 0)
            $addr_new = "'".$tmp."'";
        else
            $addr_new = "NULL";

        $is_new = 0;
        $views = 0;

        $sqls[$i] = "INSERT INTO Store (name, category, region, type1, type2, img, owner_comment, contact, store_hour, property, property_show, note, lat, lng, addr_old, addr_new, is_new, views) VALUES ('$name', $category, $region, $type1, $type2, '$img', $owner_comment, $contact, '$store_hour', $property, $property_show, '$note', $lat, $lng, $addr_old, $addr_new, $is_new, $views)";

        if($echo) {
            echo(" : $name");
            echo("<br>");
        }
    }

    foreach ($sqls as &$sql) {
        echo(substr($sql, 181));
        echo("<br>");
    }
?>

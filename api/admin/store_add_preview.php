<?php
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    if($imageFileType == "csv") {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        die("Only csv file is allowed");
    }

    include("../config.php");
    include_once("addr2coord.php");
    include_once('php-image-resize/lib/ImageResize.php');
    require_once 'parsecsv-for-php/parsecsv.lib.php';

    use \Eventviva\ImageResize;
    header('Content-type:text/html;');

    $addr2coord_csv = new parseCSV();
    $addr2coord_csv->encoding('euc-kr', 'UTF-8');
    $addr2coord_csv->parse('addr2coord.csv');
    $addr2coord = $addr2coord_csv->data;

    $csv = new parseCSV();
    $csv->parse('uploads/store_data.csv');
    $data = $csv->data;
    $length = count($data);

    echo("<table border=\"1\"><tr>");
    echo("<td>상점이름</td>");
    echo("<td>대분류</td>");
    echo("<td>지역</td>");
    echo("<td>분류1</td>");
    echo("<td>분류2</td>");
    echo("<td>상점이미지</td>");
    echo("<td>사장님한마디</td>");
    echo("<td>연락처</td>");
    echo("<td>운영시간</td>");
    echo("<td>속성</td>");
    echo("<td>속성 표시</td>");
    echo("<td>특이사항</td>");
    echo("<td>위도</td>");
    echo("<td>경도</td>");
    echo("<td>지번주소</td>");
    echo("<td>도로명주소</td>");
    echo("</tr>");
    $has_error = false;
    $sqls = array();
    for($i = 0; $i < $length; $i++) {
        echo("<tr>");
        $echo = false;

//STORE NAME
        $key = array_keys($data[$i]);
        $tmp = $data[$i][$key[0]];
        $tmp = trim($tmp);
        $name = $tmp;

        //If there is no store name, then consider this row is empty row
        if(strcmp($name, "") == 0)
            continue;

        echo("<td>$name</td>");

        //Check this store already inserted
        $escape_name = mysqli_real_escape_string($conn, $name);
        $sql = "SELECT _id FROM Store WHERE name='$escape_name'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            echo("<td colspan=\"5\">is already inserted</td>");
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
            echo("<td colspan=\"5\">대분류 is invalid value - '$tmp'</td>");
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
            echo("<td colspan=\"5\">지역 is invalid value - '$tmp'</td>");
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
            echo("<td colspan=\"5\">분류1 is invalid value - '$tmp'</td>");
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
            $tmp1 = $data[$i]["가격(밥)"];
            $tmp2 = $data[$i]["분위기(술)"];
            $tmp3 = $data[$i]["목적(카페)"];
            echo("<td colspan=\"5\">분류2 is invalid value - '$tmp1' '$tmp2' '$tmp3'</td>");
        }

//STORE IMAGE
        $img = "";
        $tmp = $data[$i]["상점이미지"];
        $tmp = trim($tmp);

        if(strcmp($tmp, "없음") == 0 || strcmp($tmp, "") == 0) {
            $img = "http://ziumcompany.net/asset/image/no_img.jpg";
        } else {
            $tmps = explode(".",$tmp);
            $image_name = $tmps[0];
            $formats = Array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG");
            foreach($formats as &$format) {
                if(file_exists("../../asset/store/$name/$image_name.$format")) {
                    $img = "http://ziumcompany.net/asset/store/$name/$image_name.$format";
                    break;
                }
            }

            if(strcmp($img,"") == 0) {
                $echo = $has_error = true;
                echo("<td colspan=\"5\">상점이미지 is not exists in - '$name/$image_name'</td>");
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
        if(strcmp(substr($tmp,0,1),"/") == 0) $tmp = substr($tmp, 1);
        $tmp = str_replace("(","",$tmp);
        $tmp = str_replace(")","-",$tmp);
        $tmps = explode("/",$tmp);
        $tmp = trim($tmps[0]);
        if(preg_match("/[\\d]{2,3}-[\\d]{3,4}-[\\d]{4,4}/i", $tmp)) {
            $contact = "'$tmp'";
        } else {
            if(strcmp($tmp, "없음") == 0 || strcmp($tmp, "") == 0) {
                $contact = "NULL";
            } else {
                $echo = $has_error = true;
                echo("<td colspan=\"5\">연락처 is invalid value - '$tmp'</td>");
            }
        }

//STORE HOURS
        $tmp = $data[$i]["운영시간"];
        $tmp = trim($tmp);
        $tmp = preg_replace("/[\\s]+\/[\\s]+/i","\\n",$tmp);
        $store_hour = $tmp;

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
                    echo("<td colspan=\"5\">$key is invalid value - '$tmp'</td>");
                }
            }
        }

//NOTE
        $tmp = $data[$i]["특이사항"];
        $tmp = trim($tmp);
        $tmp = preg_replace("/[\\s]+\/[\\s]+/i","\\n",$tmp);
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
            echo("<td colspan=\"5\">Address must be more than one</td>");
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
                        // echo("exists $lat $lng '$addr_old' '$addr_new', ");
                    } else {
                        $echo = $has_error = true;
                        echo("<td colspan=\"5\">Invalid Address ".$json["json"]."</td>");
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

                    // echo("insert $lat $lng '$addr_old' '$addr_new', ");
                } else {
                    $echo = $has_error = true;
                    echo("<td colspan=\"5\">Invalid Address ".$json["json"]."</td>");
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

        if(!$echo) {
            mysqli_query($conn, "START TRANSACTION");
            try {
                $sql = "INSERT INTO Store (name, category, region, type1, type2, img, owner_comment, contact, store_hours, property, property_show, note, lat, lng, addr_old, addr_new, is_new, views) VALUES ('$escape_name', $category, $region, $type1, $type2, '$escape_img', $owner_comment, $contact, '$store_hour', $property, $property_show, '$note', $lat, $lng, $addr_old, $addr_new, $is_new, $views)";
                if(!mysqli_query($conn, $sql)) {
                    throw new \Exception('sql_error');
                }
                $id = mysqli_insert_id($conn);

                rename("../../asset/store/$name","../../asset/store/$id");
                $folder_path = "../../asset/store/$id";
                mkdir("$folder_path/thumb",0777,true);

                $files = scandir($folder_path);
                for($j = 0; $j < count($files); $j++) {
                    $file_name = $files[$j];
                    if(strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0 || strcmp($file_name,"thumb") == 0) continue;
                    echo("file_name : $file_name<br>");

                    $file_size = filesize("$folder_path/$file_name");
                    $ratio = intval(sqrt(1000000/$file_size) * 130);
                    if($ratio < 100) {
                        $image = new ImageResize("$folder_path/$file_name");
                        $image->scale($ratio);
                        $image->save("$folder_path/$file_name");
                    }

                    $file_size = filesize("$folder_path/$file_name");
                    $ratio = intval(sqrt(100000/$file_size) * 130);
                    $ratio = ($ratio > 100) ? 100 : $ratio;
                    $image = new ImageResize("$folder_path/$file_name");
                    $image->scale($ratio);
                    $image->save("$folder_path/thumb/$file_name");
                    chmod("$folder_path/thumb/$file_name",0777);
                }

                $files = scandir($folder_path);
                for($j = 0; $j < count($files); $j++) {
                    $file_name = $files[$j];
                    if(strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0 || strcmp($file_name,"thumb") == 0) continue;

                    if(preg_match("/[가-힣ㄱ-ㅎㅏ-ㅣ]/i", $file_name)) {
                        $ext = pathinfo("$folder_path/$file_name");
                        $new_file_name = hash("crc32",$file_name).".".$ext["extension"];
                        rename("$folder_path/$file_name","$folder_path/$new_file_name");
                        rename("$folder_path/thumb/$file_name","$folder_path/thumb/$new_file_name");
                        echo("rename : $file_name -> $new_file_name<br>");
                    }
                }

                $files = scandir("$folder_path/thumb");
                for($j = 0; $j < count($files); $j++) {
                    $file_name = $files[$j];
                    if(strcmp($file_name,".") == 0 || strcmp($file_name,"..") == 0 || strcmp($file_name,"thumb") == 0) continue;
//                    $is_menu = (strcmp(substr($file_name, 0, 1), "m") == 0) ? 1 : 0;
                    $is_menu = (strpos($file_name, "menu") !== false) ? 1 : 0;
                    $img_url = "http://ziumcompany.net/asset/store/".$id."/thumb/$file_name";
                    $escape_img_url = mysqli_real_escape_string($conn, $img_url);

                    if(!mysqli_query($conn, "INSERT INTO StoreImage (store_id, is_menu, img) VALUES ($id, $is_menu, '$escape_img_url')")) {
                        throw new \Exception('sql_error');
                    }
                    echo("save : $img_url<br>");
                }

                if(!(strpos($a, 'no_img.jpg') !== false)) {
                    $new_img = str_replace("$name/","$id/thumb/",$img);
                    $new_escape_img = mysqli_real_escape_string($conn, $new_img);

                    if(!mysqli_query($conn, "UPDATE Store SET img = '$new_escape_img' WHERE _id = $id")) {
                        throw new \Exception('sql_error');
                    }
                    echo("changed to : $new_img<br>");
                }
                echo("<br>");

                mysqli_query($conn,"commit");

                echo("<td>$category</td>");
                echo("<td>$region</td>");
                echo("<td>$type1</td>");
                echo("<td>$type2</td>");

                if(isset($new_img))
                    echo("<td>$new_img</td>");
                else
                    echo("<td>$img</td>");

                echo("<td>$owner_comment</td>");
                echo("<td>$contact</td>");
                echo("<td>$store_hour</td>");
                echo("<td>$property</td>");
                echo("<td>$property_show</td>");
                echo("<td>$note</td>");
                echo("<td>$lat</td>");
                echo("<td>$lng</td>");
                echo("<td>$addr_old</td>");
                echo("<td>$addr_new</td>");
                echo("<td>success</td>");
            } catch (Exception $e) {
                mysqli_query($conn, "ROLLBACK");
                if(strcmp($e->getMessage(),'sql_error') == 0) {
                    echo("<td colspan=\"5\">".mysqli_error($conn)."</td>");
                } else {
                    echo("<td colspan=\"5\">".$e->getMessage()."</td>");
                    echo("<td colspan=\"5\">".$e->getTraceAsString()."</td>");
                }
            }


        } else {
            echo("<td>fail</td>");
        }
        echo("</tr>");
    }
?>

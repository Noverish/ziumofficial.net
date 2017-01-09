<?php
    include("config.php"); 

    mysql_query("set session character_set_connection=utf8;");
    mysql_query("set session character_set_results=utf8;");
    mysql_query("set session character_set_client=utf8;");
    // 회원 DB에서 회원 정보를 가져옵니다.
    $result1 = mysql_query("SELECT *FROM RandomWord1") or die(mysql_error());
    $result2 = mysql_query("SELECT *FROM RandomWord2") or die(mysql_error());

    $result_user = mysql_query("SELECT user_name FROM User") or die(mysql_error());

    if (mysql_num_rows($result1) > 0) {
        $word1_list = array();
     
        while ($row1 = mysql_fetch_array($result1)) {
            array_push($word1_list, $row1["word"]);
        }

        if (mysql_num_rows($result2) > 0) {
            $word2_list = array();
         
            while ($row2 = mysql_fetch_array($result2)) {
                array_push($word2_list, $row2["word"]);
            }

            $word1 = mt_rand(0, mysql_num_rows($result1)-1);
            $word2 = mt_rand(0, mysql_num_rows($result2)-1);
            $response["user_name"] = $word1_list[$word1].$word2_list[$word2];
            

            if (mysql_num_rows($result_user) > 0) {
                
                while ($rowUser = mysql_fetch_array($result_user)) {
                    echo 'userName: '.$rowUser['user_name'];
                    echo 'check: '.$response['user_name'];
                    if($rowUser['user_name']==$response["user_name"]){
                        $word1 = mt_rand(0, mysql_num_rows($result1)-1);
                        $word2 = mt_rand(0, mysql_num_rows($result2)-1);
                        $response["user_name"] = $word1_list[$word1].$word2_list[$word2];

                        break;
                    }
                }
                $response["res"] = 1;
                $response["msg"] = 'success';
            }
            else{
                $response["res"] = 0;
                $response["msg"] = 'failed to load user';
            }
        }
        else{
            $response["res"] = 0;
            $response["msg"] = 'failed to load randomword2';
        }
    }
    else{
        $response["res"] = 0;
        $response["msg"] = 'failed to load randomword1';
    }
 
    // echoing JSON response
    echo json_encode($response);
           
?>
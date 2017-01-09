<?php
    include("config.php");
    // 회원 DB에서 회원 정보를 가져옵니다.
    $result1 = mysqli_query("SELECT *FROM RandomWord1") or die(mysqli_error());
    $result2 = mysqli_query("SELECT *FROM RandomWord2") or die(mysqli_error());

    $result_user = mysqli_query("SELECT user_name FROM User") or die(mysqli_error());

    if (mysqli_num_rows($result1) > 0) {
        $word1_list = array();

        while ($row1 = mysqli_fetch_array($result1)) {
            array_push($word1_list, $row1["word"]);
        }

        if (mysqli_num_rows($result2) > 0) {
            $word2_list = array();

            while ($row2 = mysqli_fetch_array($result2)) {
                array_push($word2_list, $row2["word"]);
            }

            $word1 = mt_rand(0, mysqli_num_rows($result1)-1);
            $word2 = mt_rand(0, mysqli_num_rows($result2)-1);
            $response["user_name"] = $word1_list[$word1].$word2_list[$word2];


            if (mysqli_num_rows($result_user) > 0) {

                while ($rowUser = mysqli_fetch_array($result_user)) {
                    echo 'userName: '.$rowUser['user_name'];
                    echo 'check: '.$response['user_name'];
                    if($rowUser['user_name']==$response["user_name"]){
                        $word1 = mt_rand(0, mysqli_num_rows($result1)-1);
                        $word2 = mt_rand(0, mysqli_num_rows($result2)-1);
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

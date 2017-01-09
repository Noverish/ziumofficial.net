<?php
    include("config.php");

    $result_user = mysql_query("SELECT user_name, kakaoID FROM User") or die(mysql_error());

    $input_name = $_POST['user_name'];
    $input_id = $_POST['kakaoID'];

    $register_check = 1;
    if (mysql_num_rows($result_user) > 0) {
        $response["res"] = 1;
        $response["msg"] = 'registered!';

        while ($rowUser = mysql_fetch_array($result_user)) {
            if($rowUser['kakaoID']==$input_id){
                $response["res"] = 0;
                $response["msg"] = $input_id.' is already joined';
                $register_check=0;
                break;
            }
        }

        if($register_check==1){
            $sql = "INSERT into User (kakaoID,user_name,is_owner,push,reg_date,score,warning) VALUES ($input_id,'$input_name',0,0000,now(),0,0)";
            $result_register = mysql_query($sql) or die(mysql_error());
            echo $result_register;
        }
    }
    else{
        $response["res"] = 0;
        $response["msg"] = 'failed to load user';
    }
    // echoing JSON response
    echo json_encode($response);

?>

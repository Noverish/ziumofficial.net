<?php
    include("config.php");

    $result_user = mysqli_query("SELECT user_name FROM User") or die(mysqli_error());

    $input_name = $_POST['user_name'];
    if (mysqli_num_rows($result_user) > 0) {
        $response["res"] = 1;
        $response["msg"] = 'you can use this nickname';
        while ($rowUser = mysqli_fetch_array($result_user)) {
            if($rowUser['user_name']==$input_name){
                $response["res"] = 0;
                $response["msg"] = $input_name.'is already joined';
                break;
            }
        }
    }
    else{
        $response["res"] = 0;
        $response["msg"] = 'failed to load user';
    }
    // echoing JSON response
    echo json_encode($response);

?>

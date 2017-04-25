<?php
/**
  * Send push notification
  *
  * @author hyunsub.kim(embrapers263@gmail.com)
  */

    /**
     * Send push notification to a user
     *
     * @param int $user_id
     * @param string $title
     * @param string $content
     * @param string $ticker    only used for android
     * @param int $is_android   1 for android, 0 for iOS, -1 for unknown
     * @return none none
 	 */
    function send_noti($user_id, $title, $content, $ticker, $is_android) {
        $SERVER_KEY = "AAAARCNNKRI:APA91bGwIaaysS3M9vGv-QYnOkTqjIiyWH3Jz3fPkLisqQlMhr-d85BjEBkodCDa4cu_Ha3umqZt5ES2g-CNoznqw6SImMfZm6ft4fSEB1CDQ8fv6V5XugNZUAe5XWyO2jxg7m0A8fge";
        global $conn;

        $sql = "SELECT token FROM User WHERE _id = $user_id";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $token = $row[0];

            //this data using for android
            $data["title"] = $title;
            $data["content"] = $content;
            $data["ticker"] = $ticker;
            $json["data"] = $data;

            //When json contains both 'data' key and 'notification' key,
            //android app does not make a sound for push notification
            if($is_android != 1) {
                //this data using for iOS
                $notification["title"] = $title;
                $notification["body"] = $content;
                $json["notification"] = $notification;
            }

            $json["to"] = $token;

            $url = "https://fcm.googleapis.com/fcm/send";
            $content = json_encode($json);

            $header = array();
            $header[] = 'Content-type: application/json';
            $header[] = "Authorization: key=$SERVER_KEY";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            // if ( $status != 200 ) {
            //     die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
            // }

            curl_close($curl);

            $response = json_decode($json_response, true);
            // print_r($response);
        }
    }
?>

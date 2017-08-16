<?php
    include("config.php");

    ($user_id = $_POST["user_id"]) != NULL or print_error_and_die("There is no user_id");

    if(!is_numeric($user_id)) print_error_and_die("user_id is not number");

    $sql =
        "SELECT is_owner, user_name, ".
        "(SELECT COUNT(*) + 1 FROM User WHERE score > u.score) AS rank, score, ".
        "(SELECT COUNT(*) > 0 FROM UserMsg WHERE user_id = u._id AND is_user_sent = FALSE AND is_user_read = FALSE) AS has_noti ".
        "FROM User AS u WHERE _id = $user_id";
    $result = mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
    if($result == null || $result == false ||mysqli_num_rows($result) == 0) {
        $data['res'] = 0;
        $data['msg'] = "There is no user whose id is $user_id";
    } else {
        $data = mysqli_fetch_assoc($result);
        $data['res'] = 1;
        $date['msg'] = 'success';
        $data["has_noti"] = $data["has_noti"] != 0;
    }

    echo raw_json_encode($data);
?>

<?php
    include('../../config.php');

    ($old_name = $_POST["old_name"]) != NULL or print_error_and_die("There is no old_name");
    ($new_name = $_POST["new_name"]) != NULL or print_error_and_die("There is no new_name");
    ($key = $_POST["key"]) != NULL or print_error_and_die("There is no key");

    if(strcmp($key, "&&&&") != 0)
        print_error_and_die("Wrong Key");

    $old_name_escape = mysqli_real_escape_string($conn, $old_name);
    $new_name_escape = mysqli_real_escape_string($conn, $new_name);

    $sql="START TRANSACTION";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $sql="SELECT kakaoID FROM User WHERE user_name = '$old_name_escape'";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if(mysqli_num_rows($result) == 0)
        print_error_and_die("There is no user whose name is $old_name");
    else {
        $row = mysqli_fetch_assoc($result);
        $old_kakao_id = $row['kakaoID'];
    }

    $sql="SELECT kakaoID FROM User WHERE user_name = '$new_name_escape'";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if(mysqli_num_rows($result) == 0)
        print_error_and_die("There is no user whose name is $new_name");
    else {
        $row = mysqli_fetch_assoc($result);
        $new_kakao_id = $row['kakaoID'];
    }

    $tmp = rand(1111,9999);

    $sql="UPDATE User SET kakaoID=$tmp WHERE kakaoID=$new_kakao_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if(mysqli_affected_rows($conn) == 0)
        print_error_and_die("There is no user whose kakaoID is $new_kakao_id");

    $sql="UPDATE User SET kakaoID=$new_kakao_id WHERE kakaoID=$old_kakao_id";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if(mysqli_affected_rows($conn) == 0)
        print_error_and_die("There is no user whose kakaoID is $old_kakao_id");

    $sql="UPDATE User SET kakaoID=$old_kakao_id WHERE kakaoID=$tmp";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    if(mysqli_affected_rows($conn) == 0)
        print_error_and_die("There is no user whose kakaoID is $tmp");

    $sql="COMMIT";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    $data['res'] = 1;
    $data['msg'] = 'success';
    echo raw_json_encode($data);
?>

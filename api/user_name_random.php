<?php
    include("config.php");

    $result_user = mysqli_query($conn,"SELECT user_name FROM User") or print_sql_error_and_die($conn, "");
    $result1 = mysqli_query($conn,"SELECT * FROM RandomWord1") or print_sql_error_and_die($conn, "");
    $result2 = mysqli_query($conn,"SELECT * FROM RandomWord2") or print_sql_error_and_die($conn, "");

    $word1_list = array();
    $word2_list = array();
    $name_list = array();

    while ($row1 = mysqli_fetch_array($result1))
        array_push($word1_list, $row1["word"]);

    while ($row2 = mysqli_fetch_array($result2))
        array_push($word2_list, $row2["word"]);

    while ($rowUser = mysqli_fetch_array($result_user))
        array_push($name_list, $rowUser["user_name"]);

    //모든 경우를 다 담는 array를 만든다
    //array의 크기는 n*m이다
    $all = array();

    //all에 모든 경우의 수를 다 집어 넣는다.
    foreach ($word1_list as &$word1)
        foreach ($word2_list as &$word2)
            array_push($all, $word1.$word2);

    //remain은 all에서 name_list를 빼고 남은 것이다
    //즉, 가능한 모든 경우의 수에서 실제 사용한 것을 뺀 것이다.
    $remain = array_diff($all, $name_list);

    //남은 게 없다면 모든 경우를 다 사용하였으니
    if(count($remain) == 0) {
        $res["res"] = 2;
        $res["msg"] = 'all cases is exists';
    } else {
        shuffle($remain); //remain을 섞는다
        $res["res"] = 1;
        $res["msg"] = 'success';
        $res["user_name"] = $remain[0];
    }

    echo raw_json_encode($res);
?>

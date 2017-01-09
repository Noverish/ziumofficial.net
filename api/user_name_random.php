<?php
    include("config.php");
    // 회원 DB에서 회원 정보를 가져옵니다.

    $result_user = mysqli_query($conn,"SELECT user_name FROM User") or print_error_and_die($mysqli_error($conn));
    $result1 = mysqli_query($conn,"SELECT *FROM RandomWord1") or print_error_and_die($mysqli_error($conn));
    $result2 = mysqli_query($conn,"SELECT *FROM RandomWord2") or print_error_and_die($mysqli_error($conn));

    if (mysqli_num_rows($result_user) == 0)
        print_error_and_die('failed to load user');

    if (mysqli_num_rows($result1) == 0)
        print_error_and_die('failed to load randomword1');

    if (mysqli_num_rows($result2) == 0)
        print_error_and_die('failed to load randomword2');

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
        $response["res"] = 2;
        $response["msg"] = 'all cases is exists';
        die(json_encode($response));
    }

    //remain을 다시 index가 0부터 시작하도록 만든다.
    $remain = array_values($remain);

    //random key를 하나 가져온다.
    $tmp = count($remain) - 1;
    $random = mt_rand(0, $tmp);

    $response["res"] = 1;
    $response["msg"] = 'success';
    $response["user_name"] = $remain[$random];

    echo json_encode($response);
?>

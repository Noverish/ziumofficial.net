<?php
    $mysqli_hostname = 'db.ziumcompany.net';
    $mysqli_user = 'ziumofficial';
    $mysqli_password = 'zntbffod1!';
    $mysqli_database = 'dbziumofficial';

    $conn = mysqli_connect($mysqli_hostname, $mysqli_user, $mysqli_password, $mysqli_database) or die("db connect error");

    mysqli_query($conn,"set session character_set_connection=utf8;");
    mysqli_query($conn,"set session character_set_results=utf8;");
    mysqli_query($conn,"set session character_set_client=utf8;");

    //from http://stackoverflow.com/a/16498714
    function raw_json_encode($input, $flags = 0) {
        $fails = implode('|', array_filter(array(
            '\\\\',
            $flags & JSON_HEX_TAG ? 'u003[CE]' : '',
            $flags & JSON_HEX_AMP ? 'u0026' : '',
            $flags & JSON_HEX_APOS ? 'u0027' : '',
            $flags & JSON_HEX_QUOT ? 'u0022' : '',
        )));
        $pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
        $callback = function ($m) {
            return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
        };
        return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
    }

    function print_error_and_die($msg) {
        $response["res"] = 0;
        $response["msg"] = $msg;
        die(raw_json_encode($response));
    }

    function print_sql_error_and_die($conn, $sql) {
        $response["res"] = 0;
        $response["msg"] = mysqli_error($conn);
        $response["sql"] = $sql;
        die(raw_json_encode($response));
    }

    function query_result_to_array($result) {
        $data = array();
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    $PAGE_SIZE = 20;

    $SCORE_ATTEND = 3;
    $SCORE_REVIEW = 10;
    $SCORE_REVIEW_MAX = 3;
    $SCORE_SENT_LIKE = 1;
    $SCORE_SENT_LIKE_MAX = 5;
    $SCORE_RCVD_LIKE = 2;

    header('Content-type:application/json;charset=utf-8');
?>

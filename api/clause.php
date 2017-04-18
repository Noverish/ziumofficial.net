<?php
    include('config.php');

    ($clause = $_POST["clause"]) != NULL or print_error_and_die("There is no clause");

    if($clause == 1) {
        $clause = file_get_contents('../asset/clause/usage.txt', FILE_USE_INCLUDE_PATH);
    } else if($clause == 2) {
        $clause = file_get_contents('../asset/clause/privacy.txt', FILE_USE_INCLUDE_PATH);
    } else if($clause == 3) {
        $clause = file_get_contents('../asset/clause/announce.txt', FILE_USE_INCLUDE_PATH);
    } else if($clause == 4) {
        $clause = file_get_contents('../asset/clause/help.txt', FILE_USE_INCLUDE_PATH);
    } else {
        print_error_and_die("clause is must be one of 1, 2, 3, 4");
    }

    $res["res"] = 1;
    $res["msg"] = "success";
    $res["data"] = $clause;

    echo raw_json_encode($res);
?>

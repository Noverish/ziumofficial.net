<?php
    include_once("image_add_preview.php");

    if(!$has_error) {
        foreach ($sqls as &$sql) {
            mysqli_query($conn, $sql) or print_error_and_die(mysqli_error($conn));
            echo("SUCCESS - $sql");
            echo("<br>");
        }
    } else {
        echo("ERROR!!!!");
    }
?>

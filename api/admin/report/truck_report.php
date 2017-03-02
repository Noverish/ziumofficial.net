<?php
    include('../../config.php');
    header('Content-type:text/html;charset=utf-8');

    ($key = $_POST["key"]) != NULL or print_error_and_die("There is no key");

    if(strcmp($key, "3.1415926") != 0)
        print_error_and_die("Wrong Key");

    $sql="SELECT User.user_name as user_name, content, date ".
         "FROM TruckReport ".
         "INNER JOIN User ON User._id = TruckReport.user_id ".
         "ORDER BY date DESC ";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    echo('<table border="1">');
    echo('<tr><td>user_name</td><td>content</td><td>date</td></tr>');
    while($row = mysqli_fetch_assoc($result)) {
        echo('<tr>');
        echo('<td>'.$row['user_name'].'</td>');
        echo('<td>'.$row['content'].'</td>');
        echo('<td>'.$row['date'].'</td>');
        echo('</tr>');
    }
?>

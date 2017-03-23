<?php
    include('../../config.php');
    header('Content-type:text/html;charset=utf-8');

    foreach($_POST as $key => $value) {
        $tmp = explode("_", $key);
        $truck_id = $tmp[1];

        $sql = "UPDATE Truck SET status = $value WHERE _id = $truck_id";
        $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    }

    $sql = "SELECT * FROM Truck";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);

    echo('<form action="truck_status.php" method="post">');
    echo('<table border="1">');
    echo('<tr><td>name</td><td>location</td><td>status</td><td>note</td></tr>');
    while($row = mysqli_fetch_assoc($result)) {
        echo('<tr>');
        echo('<td>'.$row['name'].'</td>');
        echo('<td>'.$row['location'].'</td>');

        $no = $yes = $unknown = "";
        switch ($row['status']) {
            case '0':
                $no = "checked";
                break;
            case '1':
                $yes = "checked";
                break;
            case '2':
                $unknown = "checked";
                break;
            default:
                break;
        }

        echo('<td>');
        echo('<input type="radio" name="status_'.$row['_id'].'" value="0" '.$no.'> No');
        echo('<input type="radio" name="status_'.$row['_id'].'" value="1" '.$yes.'> Yes');
        echo('<input type="radio" name="status_'.$row['_id'].'" value="2" '.$unknown.'> Unknown');
        echo('</td>');

        echo('<td>'.$row['note'].'</td>');
        echo('</tr>');
    }
    echo('</table>');
    echo('<input type="submit" value="submit"/>');
    echo('</form>');
 ?>

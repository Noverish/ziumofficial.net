
<?php
$mysql_hostname = 'db.ziumcompany.net';
$mysql_user = 'ziumofficial';
$mysql_password = 'zntbffod1!';
$mysql_database = 'dbziumofficial';

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("db connect error");
mysql_select_db($mysql_database, $bd) or die("db connect error");

?>

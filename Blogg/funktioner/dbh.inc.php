<?php
$dbServername = 'localhost';
$dbUsername = 'user';
$dbPassword = '';
$dbName = 'TheProvider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqlI_set_charset($conn, "utf8mb4");

?>

<?php 
$dbServername = 'localhost';
$dbUsername = 'TheProvider';//TheProvider
$dbPassword = 'lösenord';//lösenord
$dbName = 'TheProvider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqlI_set_charset($conn, "utf8mb4");

?>

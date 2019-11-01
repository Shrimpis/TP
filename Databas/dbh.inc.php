<?php 
$dbServername = 'localhost';
$dbUsername = 'root';//TheProvider
$dbPassword = '';//lösenord
$dbName = 'the_provider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqlI_set_charset($conn, "utf8mb4");

?>

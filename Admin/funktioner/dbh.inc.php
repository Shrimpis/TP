<?php 
$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'theprovider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqlI_set_charset($conn, "utf8mb4");

?>
<?php 
$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'the_provider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");

?>
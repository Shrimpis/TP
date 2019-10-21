<?php 
$dbServername = '10.130.216.101';
$dbUsername = 'TheProvider';
$dbPassword = 'lösenord';
$dbName = 'TheProvider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");

?>
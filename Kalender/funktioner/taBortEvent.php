<?php

$dbServername = 'localhost';
$dbUsername = 'user';
$dbPassword = '';
$dbName = 'TheProvider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqlI_set_charset($conn, "utf8mb4");

function taBortEvent($conn){

    if(isset($_POST['id']) ){
        $id = $_POST['id'];
        
    }

    $event = $conn->query('select * from event where id ='.$id);
    
    $sql = "DELETE FROM event WHERE id='{$id}'";
    $conn->query($sql);

             
}

?>
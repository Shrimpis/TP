<?php

$dbServername = 'localhost';
$dbUsername = 'user';
$dbPassword = '';
$dbName = 'TheProvider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqlI_set_charset($conn, "utf8mb4");

function tabortEvent($conn){
    //include('dbh.inc.php');
    if(isset($_POST['id']) ){
        $id = $_POST['id'];
        
    
    $event = $conn->query('select * from event where id ='.$id);

    $row=$event->fetch_assoc();

    $eventId=$row['id'];

    if($id==$eventId ){
        
        $sql = "DELETE FROM event WHERE id='{$id}'";
        $conn->query($sql);
    }
    else{
        
        include("./json/felhantering.php");
        hantering('400','Event id existerar inte på databasen.',);
    }
    }  
}
?>
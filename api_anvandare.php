<?php

//hämtar användarId med hjälp av nyckel. fungerar bara om en post nyckel finns. om api används så är den set.
function getAnvandare($conn){
            
    $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT * FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();
    $rattighetId=$row['rattighetId'];
    
    $sql = "SELECT * FROM kundrattigheter WHERE id = '$rattighetId'";
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();
    $anvandarId=$row['kontoId'];

    return $anvandarId;









/*

$apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT * FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();
    $rattighetId=$row['rattighetId'];
    
    $sql = "SELECT * FROM kundrattigheter WHERE id = '$rattighetId'";
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();      
    $tjanstId=$row['tjanst'];
    

    $sql = "SELECT * FROM tjanst WHERE id = '$tjanstId'";  
    $result = mysqli_query($conn,$sql);
    
    $row = $result->fetch_assoc(); 

    $anvandarId=$row['anvandarId'];

    return $anvandarId;

*/ 


    
}


?>
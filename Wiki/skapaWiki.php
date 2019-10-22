<?php

$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'the_provider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");

if(isset($_POST['anvandarId']) && isset($_POST['titel'])){
    $userid = $_POST['anvandarId'];
    $title = $_POST['titel'];
    skapaWiki($userid, $title, $conn);
}


function skapaWiki($userid, $title, $conn){

    $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
    mysqli_query($conn, $skapaTjanst);
    $skapaWiki = "INSERT INTO wiki(tjanstId) VALUES (". mysqli_insert_id($conn). ")";
  
    if(mysqli_query($conn, $skapaWiki)){
        echo "INFO: Wikin har skapats.";
    } 
    else {
        echo "ERROR: Could not execute $skapaWiki. " . mysqli_error($conn);
    }
    $conn->close();

}

?>
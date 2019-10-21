<?php
$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'the_provider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");

if(isset($_POST['wikiId']) && isset($_POST['bidragsgivare']) &&isset($_POST['titel']) &&isset($_POST['innehall'])){
    $wikiId= $_POST['wikiId'];
    $bidragsGivare= $_POST['bidragsgivare'];
    $titel= $_POST['titel'];
    $innehall= $_POST['innehall'];
    skapaSida($wikiId, $bidragsGivare, $titel, $innehall, $conn);
}

function skapaSida($wikiId, $bidragsGivare, $titel, $innehall, $conn){
   
        $date= date("Y-m-d H:i");
        $sql= "INSERT INTO wikisidor(wikiId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$bidragsGivare','$bidragsGivare', '$titel','$innehall','$date')";
        $conn->query($sql);
        $conn->close();

    }

?>
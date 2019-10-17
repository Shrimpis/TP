<?php

include("blogg/funktioner/dbh.inc.php");

function skapaInlagg(){

    
    if(isset($_POST['BID']) && isset($_POST['title'])){
        $blogID= $_POST['BID'];
        $title= $_POST['title'];
        $innehall= $_POST['innehall'];
    }

    $date= date("Y-m-d H:i");
    $sql= "INSERT INTO blogginlagg(bloggId, titel, innehall, datum) VALUES ('$blogID','$title','$innehall','$date')";
    $conn->query($sql);
    $conn->close();

}


?>
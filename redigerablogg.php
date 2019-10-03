<?php

    include("dbh.inc.php");

    $Bid = $_GET['BID'];
    $title = $_GET['Titel'];
    $sql = "UPDATE blogg set title = '{$title}' WHERE BID = $Bid ";
    echo $sql;
    $conn->query($sql);
    $conn->close();
    
?>
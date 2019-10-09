<?php

    include("dbh.inc.php");

    $Bid = $_GET['BID'];
    $title = $_GET['Titel'];
    $sql = "UPDATE blogg set title = '{$title}' WHERE BID = $Bid ";
    echo $sql;
    $conn->query($sql);
    
    
    if(mysqli_query($conn, $sql)){
        echo "INFO: Bloggen har redigerats.";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
?>
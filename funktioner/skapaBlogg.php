<?php
    include("dbh.inc.php");

    $usrid = $_GET['Anvandare'];
    $title = $_GET['Titel'];
    $sql = "INSERT into blogg(title,UID) VALUES('{$title}',$usrid)";
    echo $sql;
    $conn->query($sql);
    $conn->close();
    
    if(mysqli_query($conn, $sql)){
        echo "INFO: Bloggen är nu skapad.";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }

?>

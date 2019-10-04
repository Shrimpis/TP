<?php
    include('dbh.inc.php');
    $BID = mysqli_real_escape_string($conn, $_REQUEST['BID']);
    $sql = "DELETE FROM blogg WHERE BID='{$BID}'";
    // $sql2 = "DELETE FROM blogginlagg WHERE BID='{$BID}' &&mysqli_query($conn, $sql2)";

    if(mysqli_query($conn, $sql)){
        echo "INFO: Blogg borttagen";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
?>
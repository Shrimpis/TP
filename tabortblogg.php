<?php
    include('dbh.inc.php');
    $BID = mysqli_real_escape_string($conn, $_REQUEST['BID']);
    $sql = "DELETE FROM blogg WHERE BID='$BID' AND DELETE FROM blogginlagg WHERE BID='$BID";

    if(mysqli_query($conn, $sql)){
        header("location: tabortblogg.php?bloggDel=Success");
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
?>
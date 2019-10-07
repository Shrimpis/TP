<?php
    include('dbh.inc.php');
    $KID = mysqli_real_escape_string($conn, $_REQUEST['KID']);
    $sql = "DELETE FROM kommentar WHERE KID='{$KID}'";


    if(mysqli_query($conn, $sql)){
        echo "INFO: kommentar borttaget";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
?>
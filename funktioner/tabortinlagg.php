<?php
    include('dbh.inc.php');
    $IID = mysqli_real_escape_string($conn, $_REQUEST['IID']);
    $sql = "DELETE FROM blogginlagg WHERE IID='{$IID}'";
    // $sql2 = "DELETE FROM rutor WHERE IID='{$IID}'";
    // $sql3 = "DELETE FROM textruta WHERE IID='{$IID}' &&mysqli_query($conn, $sql2)&&mysqli_query($conn, $sql3)";

    if(mysqli_query($conn, $sql)){
        echo "INFO: Blogginlagg borttaget";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
?>
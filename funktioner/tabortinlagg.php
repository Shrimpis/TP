<?php
    include('dbh.inc.php');
    $IID = mysqli_real_escape_string($conn, $_REQUEST['IID']);
    $sql = "DELETE FROM blogginlagg WHERE IID='{$IID}'";
    $sql2 = "DELETE FROM rutor WHERE IID='{$IID}'";
    $sql3 = "DELETE FROM textruta WHERE IID='{$IID}'";

    if(mysqli_query($conn, $sql)&&mysqli_query($conn, $sql2)&&mysqli_query($conn, $sql3)){
        echo "INFO: Blogginlagg borttaget";
    } else {
        echo "ERROR: Could not execute $sql,$sql2,$sql3. " . mysqli_error($conn);
    }
?>
<?php
    include('dbh.inc.php');
    $RID = mysqli_real_escape_string($conn, $_REQUEST['RID']);
    $sql = "DELETE FROM rutor WHERE RID='{$RID}'";
    // $sql2 = "DELETE FROM textruta WHERE RID='{$RID}' &&mysqli_query($conn, $sql2)";

    if(mysqli_query($conn, $sql)){
        echo "INFO: Ruta borttagen";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    //cred to eddiboi 4 givin code, thx.
?>
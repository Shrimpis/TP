<?php
include("dbh.inc.php");

    $Rid = $_GET['RID'];
    $text = $_GET['Text'];
    $ordning = $_GET['ordning'];
    $sql = "UPDATE textruta set text = '{$text}' WHERE RID = $Rid ";
    $sql2 = "UPDATE rutor set ordning = $ordning Where RID = $Rid";
    echo $sql;
    $conn->query($sql);
    $conn->query($sql2);
    $conn->close();
    header("location: ../index.php");
?>
<?php
include("dbh.inc.php");

    $Rid = $_GET['RID'];
    $text = $_GET['Text'];
    $sql = "UPDATE textruta set text = '{$text}' WHERE RID = $Rid ";
    echo $sql;
    $conn->query($sql);
    $conn->close();
?>
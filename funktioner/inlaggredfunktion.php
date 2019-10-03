<?php
include("dbh.inc.php");

    $iid = $_GET['BID'];
    $title = $_GET['Titel'];
    $sql = "UPDATE blogginlagg set title = '{$title}' WHERE BID = $iid ";
    echo $sql;
    $conn->query($sql);
    $conn->close();
?>
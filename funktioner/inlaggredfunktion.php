<?php
include("dbh.inc.php");

    $iid = $_GET['IID'];
    $title = $_GET['Titel'];
    $sql = "UPDATE blogginlagg set title = '{$title}' WHERE IID = $iid ";
    echo $sql;
    $conn->query($sql);
    $conn->close();
?>
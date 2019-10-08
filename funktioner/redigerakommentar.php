<?php
include("dbh.inc.php");

    $Kid = $_GET['KID'];
    $text = $_GET['text'];

    $sql = "UPDATE kommentar set text = '{$text}' WHERE KID = $Kid ";

    echo $sql;
    $conn->query($sql);
    $conn->close();
    header("location: ../index.php");
?>
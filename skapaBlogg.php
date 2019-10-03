
<?php

include("dbh.inc.php");

    $usrid = $_GET['Anvandare'];
    $title = $_GET['Titel'];
    $sql = "INSERT into blogg(title,UID) VALUES('{$title}',$usrid)";
    echo $sql;
    $conn->query($sql);
    $conn->close();
    
?>

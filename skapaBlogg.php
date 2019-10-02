
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "the_provider";
$conn = new mysqli($servername, $username, $password, $dbname); 

    $usrid = $_GET['Anvandare'];
    $title = $_GET['Titel'];
    $sql = "INSERT into blogg(title,UID) VALUES('{$title}',$usrid)";
    echo $sql;
    $conn->query($sql);
    $conn->close();
    
?>

<?php
include("dbh.inc.php");

if(isset($_POST['id']) && isset($_POST['namn']) && isset($_POST['anamn'])){

    $kundid = $_POST['id'];
    $namn = $_POST['namn'];
    $anamn = $_POST['anamn'];

} else {
    header("location: ../index.php?funktion=search?status=failed'");
}

?>
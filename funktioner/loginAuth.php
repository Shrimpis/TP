<?php

session_start();

if(isset($_POST["anvandare"])){
    
    $db = mysqli_connect("localhost", "root", "", "the_provider");
    $sql = "SELECT * FROM licens WHERE UID=".$_POST["anvandare"];
    $result = mysqli_fetch_assoc($db->query($sql));
    $_SESSION["UID"] = $result["UID"];
    $_SESSION["licens"] = $result["licens_key"];

    header("location: ../index.php");
}


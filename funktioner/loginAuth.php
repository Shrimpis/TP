<?php

if(isset($_POST["anvandare"])){
    
    $db = mysqli_connect("localhost", "root", "", "the_provider");
    $sql = "SELECT * FROM licens WHERE UID=".$_POST["anvandare"];
    $result = mysqli_fetch_assoc($db->query($sql));
    $_SESSION["licens"] = $result["licens_key"];
    header("location: index.php");
}


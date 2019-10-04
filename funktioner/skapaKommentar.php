<?php 
    include('dbh.inc.php');
    $UID = mysqli_real_escape_string($conn, $_REQUEST['UID']); //Användar-ID
    $IID = mysqli_real_escape_string($conn, $_REQUEST['IID']); //Blogginlägg-ID
    $text = mysqli_real_escape_string($conn, $_REQUEST['text']); //Kommentar text
    $heirarchyID = mysqli_real_escape_string($conn, $_REQUEST['heirarchyID']);

    $sql = "INSERT INTO kommentar (UID, IID, text, heirarchyID) VALUES ('$UID', '$IID', '$text', '$heirarchyID')";
    if(mysqli_query($conn, $sql)){
        echo "INFO: Kommentar skapad.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
?>
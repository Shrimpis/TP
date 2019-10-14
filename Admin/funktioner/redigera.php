<?php

// Funktion för redigera //

session_start();
include("dbh.inc.php");

        switch ($_POST['funktion']) {
            case 'redigeraKonto':
                redigeraKonto();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
   
$conn->close();

function redigeraKonto(){
    include("dbh.inc.php");
    if(isset($_POST['anamn']) && isset($_POST['losenord'] && isset($_POST['UID'])){
        $UID = $_POST['UID'];
	$anamn = $_POST['anamn'];
        $losenord = $_POST['losenord'];
    }
    $uppdateraKonto = "UPDATE anvandare SET anamn = '{$anamn}' SET losenord = '{$anamn}' WHERE UID = $UID ";
    
    if(mysqli_query($conn, $uppdateraKonto)){
        echo "INFO: kontot har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraKonto. " . mysqli_error($conn);
    }
    $conn->close();
}
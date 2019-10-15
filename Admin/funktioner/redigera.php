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
    if(isset($_POST['anamn']) && isset($_POST['losenord']) && isset($_POST['UID'])){
        $UID = $_POST['UID'];
	$anamn = $_POST['anamn'];
        $losenord = $_POST['losenord'];
    }
    $uppdateraAnamn = "UPDATE anvandare SET anamn = '{$anamn}' WHERE UID = $UID ";
    $uppdateraLosenord = "UPDATE anvandare SET losenord = '{$losenord}'  WHERE UID = $UID ";
    
    
    if(mysqli_query($conn, $uppdateraAnamn)&&mysqli_query($conn, $uppdateraLosenord)){
        echo "INFO: kontot har redigerats.";
        header('Refresh: 2; URL = ../redigerakontoform.php');
    } else {
        echo "ERROR: Could not execute $uppdateraAnamn. " . mysqli_error($conn);
    }
    $conn->close();
}
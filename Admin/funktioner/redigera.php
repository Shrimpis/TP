<?php

// Funktion för redigera //

session_start();
include("dbh.inc.php");

        switch ($_POST['funktion']) {
            case 'redigeraKonto':
                redigeraKonto();
                break;
            case 'redigeraRoll':
                redigeraRoll();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
                break;
        }
   
$conn->close();

function redigeraKonto(){
    include("dbh.inc.php");
    if(isset($_POST['anamn']) && isset($_POST['losenord']) && isset($_POST['UID'])){
        $UID = $_POST['UID'];
	    $anamn = $_POST['anamn'];
        $losenord = $_POST['losenord'];
    }
    if(isset($_POST['fnamn']) && isset($_POST['enamn']) && isset($_POST['email'])){
        $fnamn = $_POST['fnamn'];
        $enamn = $_POST['enamn'];
        $email = $_POST['email'];
    }
    $uppdateraAnamn = "UPDATE anvandare SET anamn = '{$anamn}' WHERE id = $UID ";
    $uppdateraLosenord = "UPDATE anvandare SET losenord = '{$losenord}'  WHERE id = $UID ";
    $uppdaterafnamn = "UPDATE anvandare SET fnamn = '{$fnamn}'  WHERE id = $UID ";
    $uppdateraenamn = "UPDATE anvandare SET enamn = '{$enamn}'  WHERE id = $UID ";
    $uppdateraemail = "UPDATE anvandare SET email = '{$email}'  WHERE id = $UID ";
    
    
    if(mysqli_query($conn, $uppdateraAnamn)&&mysqli_query($conn, $uppdateraLosenord)&&mysqli_query($conn, $uppdateraenamn)&&mysqli_query($conn, $uppdaterafnamn)&&mysqli_query($conn, $uppdateraemail)){
        echo "INFO: kontot har redigerats.";
        header('Refresh: 2; URL = ../kontoformsadmin.php');
    } else {
        echo "ERROR: Could not execute $uppdateraAnamn. " . mysqli_error($conn);
    }
    $conn->close();
}
function redigeraRoll(){
    include("dbh.inc.php");
    if(isset($_POST['UID']) && isset($_POST['rollid'])){
        $UID = $_POST['UID'];
	    $roll = $_POST['rollid'];
        
    }
    $uppdateraRoll= "UPDATE anvandarroll SET rollid = '{$roll}' where anvandarid = $UID";
    
    
    
    
    if(mysqli_query($conn, $uppdateraRoll)){
        echo "INFO: kontot har redigerats.";
        header('Refresh: 2; URL = ../kontoformsadmin.php');
    } else {
        echo "ERROR: Could not execute $uppdateraRoll. " . mysqli_error($conn);
    }
    $conn->close();
}
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
    if(isset($_POST['anamn']) && isset($_POST['losenord']) && isset($_POST['anvandarid'])){
        $anvandarid = $_POST['anvandarid'];
	    $anamn = $_POST['anamn'];
        $losenord = $_POST['losenord'];
    }
    if(isset($_POST['fnamn']) && isset($_POST['enamn']) && isset($_POST['email'])){
        $fnamn = $_POST['fnamn'];
        $enamn = $_POST['enamn'];
        $email = $_POST['email'];
    }
    $uppdateraAnamn = "UPDATE anvandare SET anamn = '{$anamn}' WHERE id = $anvandarid ";
    $uppdateraLosenord = "UPDATE anvandare SET losenord = '{$losenord}'  WHERE id = $anvandarid ";
    $uppdaterafnamn = "UPDATE anvandare SET fnamn = '{$fnamn}'  WHERE id = $anvandarid ";
    $uppdateraenamn = "UPDATE anvandare SET enamn = '{$enamn}'  WHERE id = $anvandarid ";
    $uppdateraemail = "UPDATE anvandare SET email = '{$email}'  WHERE id = $anvandarid ";
    
    
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
    if(isset($_POST['anvandarid']) && isset($_POST['rollid'])){
        $anvandarid = $_POST['anvandarid'];
	    $roll = $_POST['rollid'];
        
    }
    $uppdateraRoll= "UPDATE anvandarroll SET rollid = '{$roll}' where anvandarid = $anvandarid";
    
    
    
    
    if(mysqli_query($conn, $uppdateraRoll)){
        echo "INFO: kontot har redigerats.";
        header('Refresh: 2; URL = ../kontoformsadmin.php');
    } else {
        echo "ERROR: Could not execute $uppdateraRoll. " . mysqli_error($conn);
    }
    $conn->close();
}
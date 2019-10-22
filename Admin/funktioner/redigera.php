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
    if(isset($_POST['anvandarid'])){
        $anvandarid = $_POST['anvandarid'];

    if(isset($_POST['anamn'])){
        $anamn = $_POST['anamn'];
        $conn-query("UPDATE anvandare SET anamn = '{$anamn}' WHERE id = $anvandarid ");
    }
    if(isset($_POST['losenord'])){
        $losenord = $_POST['losenord'];
        $conn-query("UPDATE anvandare SET losenord = '{$losenord}'  WHERE id = $anvandarid ");
    }
    if(isset($_POST['enamn'])){
        $enamn = $_POST['enamn'];
        $conn-query("UPDATE anvandare SET enamn = '{$enamn}'  WHERE id = $anvandarid ");
    }
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $conn-query("UPDATE anvandare SET email = '{$email}'  WHERE id = $anvandarid ");
    }
    if(isset($_POST['fnamn'])){
        $fnamn = $_POST['fnamn'];
        $conn-query("UPDATE anvandare SET fnamn = '{$fnamn}'  WHERE id = $anvandarid ");
        
        
    }
    }

    
    
    
        echo "INFO: kontot har redigerats.";
        header('Refresh: 2; URL = ../kontoformsadmin.php');
    
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
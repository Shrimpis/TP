<?php 

session_start();
include("dbh.inc.php");




    
        switch ($_POST['funktion']) {
            case 'tabortKonto':
                tabortKonto();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function tabortKonto(){
    include("dbh.inc.php");
    $UID = mysqli_real_escape_string($conn, $_POST['UID']);
    $delkonto = "UPDATE anvandare SET aktiv = false WHERE id='{$UID}'";
    
    
    if(mysqli_query($conn, $delkonto)){
        echo "INFO: konto avaktiverat";
        header('Refresh: 2; URL = ../kontoformsadmin.php');
    } else {
        echo "ERROR: Could not execute $delkonto. " . mysqli_error($conn);
    }

    $conn->close();

}
?>
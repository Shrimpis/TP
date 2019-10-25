<?php 

include("../../Databas/dbh.inc.php");

    switch ($_POST['funktion']) {
        case 'aktiveraTjanst':
            aktiveraTjanst($conn);
            break;
        default:
            echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
    }
    
  

function aktiveraTjanst($conn){
   //- include("../../Databas/dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $tjanst = (isset($_POST['CheckTjanst'])) ? 1 : 0;

    $aktivera = "UPDATE `kundrattigheter` SET `tjanst` = '$tjanst' WHERE `kundrattigheter`.`id` = $id";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=aktiveraTjanst?m=success');
    } else {
        echo "ERROR: Could not able to execute $aktivera. " . mysqli_error($conn);
    }

}

?>
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

    $id = $_POST['id']; //Kund-ID
    $tjanst = (isset($_POST['CheckTjanst'])) ? 1 : 0;

    $result = ($conn->query("SELECT id FROM kundrattigheter WHERE id=$id"));

    if(mysqli_num_rows($result) > 0){
        $aktivera = "UPDATE `kundrattigheter` SET `tjanst` = '$tjanst', `superadmin` = '0', `kontoId` = '0' WHERE `kundrattigheter`.`id` = $id ";
        $conn->query($aktivera);

        header('location: ../index.php?funktion=aktiveraTjanst?m=success');
    } else {
        $aktivera = "INSERT INTO kundrattigheter(id,tjanst, superadmin, kontoId) VALUES ($id ,$tjanst, '0', '0')";
        $conn->query($aktivera);
        
        header('location: ../index.php?funktion=aktiveraTjanst?m=success');
    }

}

?>
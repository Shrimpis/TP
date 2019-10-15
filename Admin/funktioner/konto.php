<?php 

include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'avslutaKonto':
                avslutaKonto();
                break;
            case 'aktiveraKonto':
                aktiveraKonto();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function avslutaKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID

    $avsluta = "";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=avslutaKonto?m=success');
    } else {
        echo "ERROR: Could not able to execute $avsluta. " . mysqli_error($conn);
    }

}

function aktiveraKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $aktiv = '0';

    $deaktivera= "UPDATE `kund` SET `aktiv` = '$aktiv' WHERE `kund`.`id` = $id";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=deaktiveraKonto?m=success');
    } else {
        echo "ERROR: Could not able to execute $deaktivera. " . mysqli_error($conn);
    }
}

?>
<?php 

include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'avslutaKonto':
                avslutaKonto();
                break;
            case 'aktiveraKonto':
                aktiveraKonto();
                break;
            case 'deaktiveraKonto':
                deaktiveraKonto();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function avslutaKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID

    $avsluta= "";//TODO: Gör delete i en sql-sats.

    if(mysqli_query($conn, $avsluta)){
        header('location: ../index.php?funktion=avslutaKonto?m=success');
    } else {
        echo "ERROR: Could not able to execute $avsluta. " . mysqli_error($conn);
    }
    $conn->close();
}

function aktiveraKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $aktiv = '1';

    $aktivera= "UPDATE `kund` SET `aktiv` = '$aktiv' WHERE `kund`.`id` = $id";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=aktiveraKonto?m=success');
    } else {
        echo "ERROR: Could not able to execute $aktivera. " . mysqli_error($conn);
    }
    $conn->close();
}

function deaktiveraKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $aktiv = '0';

    $deaktivera= "UPDATE `kund` SET `aktiv` = '$aktiv' WHERE `kund`.`id` = $id";

    if(mysqli_query($conn, $deaktivera)){
        header('location: ../index.php?funktion=deaktiveraKonto?m=success');
    } else {
        echo "ERROR: Could not able to execute $deaktivera. " . mysqli_error($conn);
    }
    $conn->close();
}

?>
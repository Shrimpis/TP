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

    $superadmin = "UPDATE `kund` SET `superadmin` = '0' WHERE `kund`.`id` = $id";
    $avsluta = "UPDATE anvandare SET aktiv = false WHERE id='$id'";//TODO: Ändra till en Harddelete.

    if(mysqli_query($conn, $avsluta)){
        header('location: ../index.php?funktion=avslutaKonto?status=success');
    } else {
        echo "ERROR: Could not able to execute $avsluta. " . mysqli_error($conn);
    }
    $conn->close();
}

function aktiveraKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $aktiv = '1';

    $aktivera= "UPDATE `anvandare` SET `aktiv` = '$aktiv' WHERE `anvandare`.`id` = $id";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=aktiveraKonto?status=success');
    } else {
        echo "ERROR: Could not able to execute $aktivera. " . mysqli_error($conn);
    }
    $conn->close();
}

function deaktiveraKonto(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $aktiv = '0';

    $deaktivera= "UPDATE `anvandare` SET `aktiv` = '$aktiv' WHERE `anvandare`.`id` = $id";

    if(mysqli_query($conn, $deaktivera)){
        header('location: ../index.php?funktion=deaktiveraKonto?status=success');
    } else {
        echo "ERROR: Could not able to execute $deaktivera. " . mysqli_error($conn);
    }
    $conn->close();
}

?>
<?php 

include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'aktiveraTjanst':
                aktiveraTjanst();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function aktiveraTjanst(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $bloggCheck = (isset($_POST['bloggCheck'])) ? 1 : 0;
    $wikiCheck = (isset($_POST['wikiCheck'])) ? 1 : 0;
    $kalenderCheck = (isset($_POST['kalenderCheck'])) ? 1 : 0;
    $aktiv = '1'; //Aktiverar kontot.

    $aktivera = "UPDATE `kund` SET `blogg` = '$bloggCheck', `wiki` = '$wikiCheck', `kalender` = '$kalenderCheck', `aktiv` = '$aktiv' WHERE `kund`.`id` = $id";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=aktiveraTjanst?m=success');
    } else {
        echo "ERROR: Could not able to execute $aktivera. " . mysqli_error($conn);
    }

}

?>
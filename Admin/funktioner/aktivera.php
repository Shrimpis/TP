<?php 

include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'aktiveraTjanst':
                aktiveraTjanst();
                break;
            case 'aktiveraKonto':
                aktiveraKonto();
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

    $aktivera = "INSERT INTO kund (blogg, wiki, kalender, aktiv) VALUES ('$bloggCheck', '$wikiCheck', '$kalenderCheck', '$aktiv') WHERE id='$id'";

}

function aktiveraKonto(){

}

?>
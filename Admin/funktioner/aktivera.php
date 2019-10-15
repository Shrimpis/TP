<?php 

include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'aktiveraTjanst':
                aktiveraTjanst();
                break;
            case 'aktiveraTjanst':
                aktiveraKonto();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function aktiveraTjanst(){
    include("dbh.inc.php");

    $bloggCheck = (isset($_POST['bloggCheck'])) ? 1 : 0;
    $wikiCheck = (isset($_POST['wikiCheck'])) ? 1 : 0;
    $kalenderCheck = (isset($_POST['kalenderCheck'])) ? 1 : 0;

}

function aktiveraKonto(){

}

?>
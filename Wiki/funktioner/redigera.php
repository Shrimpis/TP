<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'hideWiki':
                hideWiki();
                break;
            case 'hidewiksid':
                hidewikside();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();


function hideWiki(){
    
    $wikiId = $_POST['wikiId'];

        $conn->query("UPDATE wiki SET dold=1 WHERE tjanstId = '{$wikiId}'");
        $conn->query("UPDATE wikisidor SET dold=1 WHERE wikiId = '{$wikiId}'");
        

        header('Refresh: 2; URL = ../index.php');
    $conn->close();

}








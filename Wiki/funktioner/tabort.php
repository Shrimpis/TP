<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'tabortWiki':
                tabortWiki();
                break;
            case 'tabortWikisida':
                tabortWikisida();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();


function tabortWiki(){
    include('dbh.inc.php');
    $wikiId = $_POST['wikiId'];

    $delTjanst = "DELETE FROM tjanst WHERE id='{$wikiId}'";
    $delwiki = "DELETE FROM wiki WHERE tjanstId='{$wikiId}'";
    $delsida = "DELETE FROM wikisidor WHERE wikiId='{$wikiId}'";

    
    if(mysqli_query($conn, $delwiki)&&mysqli_query($conn, $delsida)&&mysqli_query($conn, $delTjanst)){
        echo "INFO: Wiki borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute sql. " . mysqli_error($conn);
    }

    $conn->close();

}
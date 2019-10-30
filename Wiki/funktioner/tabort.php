<?php

// Funktioner för att ta bort

session_start();

include('../../Databas/dbh.inc.php');
include("../../json/felhantering.php");
        switch ($_POST['funktion']) {

            case 'tabortWiki':
                tabortWiki($conn);
                break;
            case 'tabortWikiSida':
                tabortWikiSida($conn);
                break;
            
            default:
                hantering('400','ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.');
                break;
        }

function tabortWiki($conn){
    //-include('dbh.inc.php');
    $wikiId = $_POST['wikiId'];

    $delTjanst = "DELETE FROM tjanst WHERE id='{$wikiId}'";

    
    if(mysqli_query($conn, $delTjanst)){
        hantering('202','tog bort wikin');
    } else {
        hantering('400','kunde ej exekvera');
    }

    $conn->close();

}

function tabortWikiSida($conn){
    

    $sidID = $_POST["sidId"];

    $result = ($conn->query("SELECT * FROM wikisidor WHERE id = '{$sidID}'"));
    
    $delSida = "DELETE FROM wikisidor WHERE id = '{$sidID}'";
    if(mysqli_query($delSida)){
        hantering('202','tog bort wikisidan');
    }
    else{
        hantering('400','kunde ej exekvera');
    }
}


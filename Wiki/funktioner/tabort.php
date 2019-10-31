<?php

// Funktioner för att ta bort

session_start();

include('../../Databas/dbh.inc.php');
include("../../json/felhantering.php");

if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom
    
    $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1){
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
    }
    else {        
        hantering('401','Api-nyckeln är antingen fel eller finns inte. Kontakta administratör.');
    }
}
else {
hantering('401','Api-nyckeln är inte definerad.');
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

    
    $delSida = "DELETE FROM wikisidor WHERE id = '{$sidID}'";
    if(mysqli_query($delSida)){
        hantering('202','tog bort wikisidan');
    }
    else{
        hantering('400','kunde ej exekvera');
    }
}


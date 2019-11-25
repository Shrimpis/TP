<?php

// Funktioner för att ta bort

session_start();

//include('./Databas/dbh.inc.php');
$conn = mysqli_connect('localhost','TheProvider','lösenord','TheProvider');
//include("../../json/felhantering.php");
include("./api_anvandare.php");

if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom
    
    $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1){
        switch ($_POST['funktion']) {

            case 'tabortWiki':
                tabortWiki(getAnvandare($conn),$conn);
                break;
            case 'tabortWikiSida':
                tabortWikiSida(getAnvandare($conn),$conn);
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
function tabortWiki($anvandarId,$conn){
    //-include('dbh.inc.php');
    $wikiId = $_POST['wikiId'];
    
    $delTjanst = "DELETE FROM tjanst WHERE id='{$wikiId}'";
    
    $redan_dolt = $conn->query("SELECT * FROM wiki WHERE id ='{$wikiId}'");
    $row = $redan_dolt->fetch_assoc();
    $tjanstId=$row["tjanstId"];

    

    $tjanst= $conn ->query("SELECT * FROM tjanst WHERE id = '$tjanstId'");
    $row = $tjanst->fetch_assoc();
    $anvandarId2=$row["anvandarId"];

    if($anvandarId==$anvandarId2){
    
        if(mysqli_query($conn, $delTjanst)){
            hantering('202','tog bort wikin');
        } else {
            hantering('400','kunde ej exekvera');
        }
    }
    else{
        hantering('400','något har gått fel med anvandare');
    }

    $conn->close();

}

function tabortWikiSida($anvandarId,$conn){
    $sidID = $_POST["sidId"];

    $wikiSida = $conn->query('select * from wikisidor where id ='.$sidID);

    $row = $wikiSida->fetch_assoc();
    $wikiId=$row["wikiId"];

    $wiki = $conn->query("SELECT * FROM wiki WHERE id ='{$wikiId}'");
    $row = $wiki->fetch_assoc();
    $tjanstId=$row["tjanstId"];

    $tjanst= $conn ->query("SELECT * FROM tjanst WHERE id = '$tjanstId'");
    $row = $tjanst->fetch_assoc();
    $anvandarId2=$row["anvandarId"];

    if($anvandarId==$anvandarId2){
    
        $delSida = "DELETE FROM wikisidor WHERE id = '{$sidID}'";
        if(mysqli_query($conn,$delSida)){
            hantering('202','tog bort wikisidan');
        }
        else{
            hantering('400','kunde ej exekvera');
        }
    }
    else{
        hantering('400','något har gått fel med anvandare');
    }
}


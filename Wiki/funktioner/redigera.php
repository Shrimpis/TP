<?php

// Funktioner för att ta bort

session_start();

include('./Databas/dbh.inc.php'); 
//include("./json/felhantering.php");  
include("./api_anvandare.php");

if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom
   
    $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1){


        switch ($_POST['funktion']) {

            case 'doljWiki':
                doljWiki(getAnvandare($conn),$conn);
                break;
            case 'doljWikiSida':
                doljWikiSida(getAnvandare($conn),$conn);
                break;
            case 'godkannUppdatering':
                godkannUppdatering(getAnvandare($conn),$conn);
                break;
            case 'nekaUppdatering':
                nekaUppdatering(getAnvandare($conn),$conn);
                break;
            case 'lasaWikiSida':
                lasaWikiSida(getAnvandare($conn),$conn);
                break;
            case 'privatiseraWiki':
                privatiseraWiki(getAnvandare($conn),$conn);
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

function doljWiki($anvandarId, $conn){
    //-include('dbh.inc.php');
    $wikiId = $_POST['wikiId'];


        $redan_dolt = $conn->query("SELECT * FROM wiki WHERE id ='{$wikiId}'");
        
        $row = $redan_dolt->fetch_assoc();
        $dolt=$row["dolt"];
        
        $tjanstId=$row["tjanstId"];

        $tjanst= $conn ->query("SELECT * FROM tjanst WHERE id = '$tjanstId'");
        $row = $tjanst->fetch_assoc();
        $anvandarId2=$row["anvandarId"];

        if($anvandarId==$anvandarId2){
            if($dolt==0){
                $conn->query("UPDATE wiki SET dolt=1 WHERE id = '{$wikiId}'");
               hantering('202','wiki är dold');
           }
           else if($dolt==1){
               $conn->query("UPDATE wiki SET dolt=0 WHERE id = '{$wikiId}'");
               hantering('202','wiki är öppen');
           }
           else{
               hantering('400','något har gått fel med döljningsfunktionen');
           }
        }
        else{
            hantering('400','något har gått fel med anvandare');
        }
        
           
            
        
    $conn->close();

}

function doljWikiSida($anvandarId, $conn){

    //-include('dbh.inc.php');
    
    if(isset($_POST['id']) ){
        $id = $_POST['id'];
        
        $wikiSida = $conn->query('select * from wikisidor where id ='.$id);

        $row = $wikiSida->fetch_assoc();
        $dolj=$row["dolt"];
        $wikiId=$row["wikiId"];

        $wiki = $conn->query("SELECT * FROM wiki WHERE id ='{$wikiId}'");
        
        $row = $wiki->fetch_assoc();
      
        $tjanstId=$row["tjanstId"];

        $tjanst= $conn ->query("SELECT * FROM tjanst WHERE id = '$tjanstId'");
        $row = $tjanst->fetch_assoc();
        $anvandarId2=$row["anvandarId"];

        if($anvandarId==$anvandarId2){
            if($dolj==0){
                $sql= "UPDATE wikisidor SET dolt = 1 WHERE id = $id ";
                $conn->query($sql);
                hantering('202','wikisidan är dold');
            
            }
            else if($dolj==1){
                $sql= "UPDATE wikisidor SET dolt = 0 WHERE id = $id ";
                $conn->query($sql);
                hantering('202','wikisidan är öppen');

            }
            else{
                hantering('400','något har gått fel med döljningsfunktionen');
            }

        }
        else{
            hantering('400','något har gått fel med anvandare');
        }

    }

    $conn->close();
    
}

function godkannUppdatering($conn){

    //-include("dbh.inc.php");
    if(isset($_POST['uppdateringid']) && isset($_POST['sidId']) && isset($_POST['godkantAv'])){
        $uppdateringId = $_POST['uppdateringid'];
        $sidId = $_POST['sidId'];
        $godkantAv = $_POST['godkantAv'];

        if($sidId != 0){
            
            $skickaVersion = "INSERT INTO sidversion(sidId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES((SELECT id FROM wikisidor WHERE id = $sidId),
            (SELECT godkantAv FROM wikisidor WHERE id = $sidId), (SELECT bidragsgivare FROM wikisidor WHERE id = $sidId), (SELECT titel FROM wikisidor WHERE id = $sidId),
            (SELECT innehall FROM wikisidor WHERE id = $sidId), (SELECT datum FROM wikisidor WHERE id = $sidId))";

            $uppdateraSida = "UPDATE wikisidor SET godkantAv = $godkantAv, bidragsgivare = (SELECT bidragsgivare FROM wikiuppdatering WHERE id = $uppdateringId),
            titel = (SELECT titel FROM wikiuppdatering WHERE id = $uppdateringId), innehall = (SELECT innehall FROM wikiuppdatering WHERE id = $uppdateringId),
            datum = (SELECT datum FROM wikiuppdatering WHERE id = $uppdateringId) WHERE id = $sidId";
            
            $taBortUppdatering = "DELETE FROM wikiuppdatering WHERE id = $uppdateringId";

            if(mysqli_query($conn, $skickaVersion)){
                hantering('201','den gamla versionen flyttades');
            }else{
                hantering('400','kunde ej exekvera, den gamla versionen av sidan flyttades ej');
            }
    
            if(mysqli_query($conn, $uppdateraSida)){
                hantering('201','uppdatering skapad');
            }else{
                hantering('400','kunde ej exekvera, sidan uppdaterades ej');
            }
            if(mysqli_query($conn, $taBortUppdatering)){
                hantering('204','uppdatering flyttad');
                
    
            }else{
                hantering('400','kunde ej exekvera, uppdateringen flyttades inte från väntan');
            }
        }else if($sidId == 0){
            $nyWikiSida = "INSERT INTO wikisidor(wikiId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES((SELECT wikiId FROM wikiuppdatering WHERE id = $uppdateringId), $godkantAv,
            (SELECT bidragsgivare FROM wikiuppdatering WHERE id = $uppdateringId), (SELECT titel FROM wikiuppdatering WHERE id = $uppdateringId), (SELECT innehall FROM wikiuppdatering WHERE id = $uppdateringId), 
            (SELECT datum FROM wikiuppdatering WHERE id = $uppdateringId))";
            $taBortUppdatering = "DELETE FROM wikiuppdatering WHERE id = $uppdateringId";


            if(mysqli_query($conn, $nyWikiSida)){
                hantering('201','ny sida skapad');
            }else{
                hantering('400','kunde ej exekvera, den nya sidan skapades ej');
            }
        }
    }
    $conn->close();
}

function nekaUppdatering($conn){

    //-include("dbh.inc.php");
    if(isset($_POST['id'])&&isset($_POST['nekadAv'])){
        $id = $_POST['id'];
        $nekadAv = $_POST['nekadAv'];
        
        if(isset($_POST['anledning'])){
            $anledning = $_POST['anledning'];
        }
        else{
            $anledning = "angavs ej";
        }
        
        
        $get_data=$conn->query("SELECT * FROM wikiuppdatering WHERE id=$id");
        $row = $get_data->fetch_assoc();
        $datum = date("Y-m-d");
        $bidragsgivare = $row['bidragsgivare'];
        $titel = $row['titel'];
        $innehall = $row['innehall'];
        $wikiId = $row['wikiId'];
        $nekaUppdatering = "INSERT INTO nekadwikiuppdatering(sidId, bidragsgivare, nekadAv, titel, innehall, anledning, datum, wikiId) VALUES($id, $bidragsgivare, $nekadAv, '{$titel}', '{$innehall}', '{$anledning}', '$datum', $wikiId)";
        $tabortuppdatering = "DELETE FROM wikiuppdatering WHERE id=$id";
        if(mysqli_query($conn, $nekaUppdatering)&&mysqli_query($conn, $tabortuppdatering)){
        
            hantering('202','sidan nekad');
        
        
        }
        else{
            hantering('400','kunde ej exekvera');
            
           
        }
    
    }
    
    $conn->close();
    
    }

    function lasaWikiSida($conn){

        //-include('dbh.inc.php');

        if(isset($_POST['id']) ){
            $id = $_POST['id'];

            $wikiSida = $conn->query('select * from wikisidor where id ='.$id);
    
            $row = $wikiSida->fetch_assoc();
            $lasa=$row["last"];

            if($lasa==0){
                hantering('202','wikisidan är låst');
                $sql= "UPDATE wikisidor SET wikisidor.last = 1 WHERE id = $id ";
                $conn->query($sql);
               
            }
            else if($lasa==1){
                hantering('202','wikisidan är inte låst');
                $sql= "UPDATE wikisidor SET wikisidor.last = 0 WHERE id = $id ";
                $conn->query($sql);

            }
            else{
                hantering('400','kunde ej exekvera');
            }

        }

        $conn->close();
        
    }

    function privatiseraWiki($conn){
        //-include("dbh.inc.php");
        if(isset($_POST['wikiId'])&&isset($_POST['privat'])){
            $wikiId = $_POST['wikiId'];
            $privat = $_POST['privat'];   
            echo $_POST['wikiId'];        
        }

    
        $result = $conn->query("SELECT * FROM wiki where id= $wikiId ");
            $row = $result->fetch_assoc();
            $tjanstId = $row['tjanstId'];
            $uppdateraTjanst = "UPDATE tjanst SET privat = '{$privat}' WHERE id = $tjanstId ";
        
        
        
        
        if(mysqli_query($conn, $uppdateraTjanst)){
            hantering('202','wikin är privat');
            
        } else {
            hantering('400','kunde ej exkvera');
            
        }
        $conn->close();
    }
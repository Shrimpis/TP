<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Databasanslutning //

include("Databas/dbh.inc.php");
include("json/felhantering.php");


// Början av API //

function keyIsValid($conn){
    $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT * FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();
    $rattighetId=$row['rattighetId'];
    
    $sql = "SELECT * FROM kundrattigheter WHERE id = '$rattighetId'";
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();      
    $tjanstId=$row['tjanst'];
    

    //blogg
    $sql = "SELECT * FROM blogg WHERE tjanstId = '$tjanstId'";  
    $result = mysqli_query($conn,$sql);
    if($result->num_rows==1){
        return 'blogg';
    }

    //wiki
    $sql = "SELECT * FROM wiki WHERE tjanstId = '$tjanstId'";  
    $result = mysqli_query($conn,$sql);
    if($result->num_rows==1){
        return 'wiki';
    }
    
     //kalender
     $sql = "SELECT * FROM wiki WHERE tjanstId = '$tjanstId'";  
     $result = mysqli_query($conn,$sql);
     if($result->num_rows==1){
         return 'kalender';
     }

    return 'error';
}


if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom
<<<<<<< HEAD
=======
    //var_dump($_POST['nyckel']);
>>>>>>> json
    
    $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1){
        
        if(!empty($_POST['tjanst'])){ // Kollar efter om tjänst är tom

            switch ($_POST['tjanst']) { // Kollar efter vilken tjänst som anropas
        
                case 'blogg':
                    if(keyIsValid($conn)=='blogg'){//kollar om nyckeln är till för den tjansten.
                        bloggar();
                    }
                    else{
                        hantering('400','Denna nyckel kan inte användas till blogg.');
                    }
                    break;
                case 'wiki':
                    if(keyIsValid($conn)=='wiki'){//kollar om nyckeln är till för den tjansten.
                        wiki();
                    }
                    else{
                        hantering('400','Denna nyckel kan inte användas till wiki.');
                    }
                    break;
                case 'kalender':
                    if(keyIsValid($conn)=='kalender'){//kollar om nyckeln är till för den tjansten.
                        kalender();
                    }
                    else{
                        hantering('400','Denna nyckel kan inte användas till kalender.');
                    }
                    break;
                default:
                    hantering('404','Funktionen som anropades existerar inte. Vänligen kontrollera dokumentation.');
            }
        
        } else {            
            hantering('400','Tjanst måste vara definierad.');
        }
    } 
    else {        
        hantering('401','Api-nyckeln är antingen fel eller finns inte. Kontakta administratör.');
    }

} 
else {
    hantering('401','Api-nyckeln är inte definerad.');
}

// Tjänster //

function bloggar(){
    if($_POST['typ']=='JSON'){ // Kollar om typen som anropas är JSON
        include "Blogg/json/bloggjson.php";
    } else {
        if($_POST['typ']=='function'){ // Kollar om typen som anropas är funktion
            
            switch ($_POST['handling']) { // Kollar efter vilken handling som anropas
        
                case 'skapa':
                    include "Blogg/funktioner/skapa.php";
                    break;
                case 'tabort':
                    include "Blogg/funktioner/tabort.php";
                    break;
                case 'redigera':
                    include "Blogg/funktioner/redigera.php";
                    break;
                default:
                    hantering('400','Du måste definiera en giltig åtgärd.');
            }

        } else {
            hantering('400','Du måste definiera en giltig typ.');
        }
    }
}

function wiki(){
    if($_POST['typ']=='JSON'){ // Kollar om typen som anropas är JSON
        include "Wiki/json/wikijson.php";
    } else {
        if($_POST['typ']=='function'){ // Kollar om typen som anropas är funktion
            
            switch ($_POST['handling']) { // Kollar efter vilken handling som anropas
        
                case 'skapa':
                    include "Wiki/funktioner/skapa.php";
                    break;
                case 'tabort':
                    include "Wiki/funktioner/tabort.php";
                    break;
                case 'redigera':
                    include "Wiki/funktioner/redigera.php";
                    break;
                default:
                    hantering('400','Du måste definiera en giltig åtgärd.');
            }

        } else {
            hantering('400','Du måste definiera en giltig typ.');
        }
    }
}

function kalender(){
    if($_POST['typ']=='JSON'){ // Kollar om typen som anropas är JSON
        include "Kalender/json/kalenderjson.php";
    } else {
        if($_POST['typ']=='function'){ // Kollar om typen som anropas är funktion
            
            switch ($_POST['handling']) { // Kollar efter vilken handling som anropas
        
                case 'skapa':
                    include "Kalender/funktioner/skapa.php";
                    break;
                case 'tabort':
                    include "Kalender/funktioner/tabort.php";
                    break;
                case 'redigera':
                    include "Kalender/funktioner/redigera.php";
                    break;
                default:
                    hantering('400','Du måste definiera en giltig åtgärd.');
            }

        } else {
            hantering('400','Du måste definiera en giltig åtgärd.');
        }
    }
}

?>
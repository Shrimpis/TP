<?php

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

switch($_POST['funktion']){

    case 'skapaWiki':
        skapaWiki($conn);
        break;
    case 'skapaWikiUppdatering':
        skapaWikiUppdatering($conn);
        break;
    case 'sokFalt':
        sokFalt($conn);
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

function skapaWiki($conn){

    //-include('dbh.inc.php');

    if(isset($_POST['anvandarId']) && isset($_POST['titel'])){
        $userid = $_POST['anvandarId'];
        $title = $_POST['titel'];
        //var_dump($conn);
        $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
        mysqli_query($conn, $skapaTjanst);
        $skapaWiki = "INSERT INTO wiki(tjanstId) VALUES (". mysqli_insert_id($conn). ")";
    
        if(mysqli_query($conn, $skapaWiki)){
            hantering('201','wiki skapad');
        } 
        else {
            hantering('400','kunde ej exekvera');
        }
    
    }
    $conn->close();

}

function skapaWikiUppdatering($conn){

    //-include('dbh.inc.php');

    if(isset($_POST['wikiId']) && isset($_POST['sidId']) && isset($_POST['bidragsgivare']) &&isset($_POST['titel']) &&isset($_POST['innehall'])){

        //var_dump($conn);
        $wikiId= $_POST['wikiId'];
        $sidId= $_POST['sidId'];
        $bidragsGivare= $_POST['bidragsgivare'];
        $titel= $_POST['titel'];
        $innehall= $_POST['innehall'];

        $anvandarroll = $conn->query('select * from anvandarroll where anvandarId='.$bidragsGivare);
        if($sidId!=""){
            $wikissId = $conn->query('select * from wikisidor where id='.$sidId);
            $row1 = $wikissId->fetch_assoc();
            $sidaId=$row1["id"];
        }

        $row = $anvandarroll->fetch_assoc();
        $roll=$row["rollId"];

        $date= date("Y-m-d H:i");
            if(($roll=="1" || $roll=="3") && $sidId==""){
                $sql= "INSERT INTO wikisidor(wikiId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$bidragsGivare','$bidragsGivare', '$titel','$innehall','$date')";
                
                
            }
            else if(($roll=="1" || $roll=="3") && $sidId==$sidaId){
                $sql= "UPDATE wikisidor SET godkantAv='$bidragsGivare',bidragsgivare='$bidragsGivare',titel='$titel',innehall='$innehall',datum='$date' WHERE id=$sidId";
                
            }
            else if(($roll!="1" || $roll!="3") && $sidId==""){
                $sql= "INSERT INTO wikiuppdatering(wikiId, sidId, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$sidId','$bidragsGivare', '$titel','$innehall','$date')";
                
            }
            else{
                $sql= "INSERT INTO wikiuppdatering(wikiId, sidId, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$sidId','$bidragsGivare', '$titel','$innehall','$date')";
                
            }
            if(mysqli_query($sql)){
                hantering('201','skapade uppdatering');
            }
            else{
                hantering('400','kunde ej exekvera');
            }
        
    }
        
    $conn->close();

}

function sokFalt($conn){

    //-include('dbh.inc.php');

    if(isset($_POST['sok'])){
        
        $sok= $_POST['sok'];
    
        $query = mysqli_query($conn,"SELECT * FROM wikisidor WHERE titel LIKE '%$sok%'") or die ("Could not search");
        if($count = mysqli_num_rows($query)){

            $i=0;
            $results=array();
            while($row = $query->fetch_assoc()){
                $results[$i]=$row['titel'];
                $i++;
                //$result = 'hittade wikisida: '.$row['titel'];
                //hantering('201',$result);
            }
            
            $json=json_encode($results);
            echo $json;
        }
        
        else if($count == 0){
            hantering('201','hittade inget');//vill inte skicka error men vad ska man göra.
        }

        

    } 

    $conn->close();

}



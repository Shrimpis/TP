<?php

session_start();
include('./Databas/dbh.inc.php');

switch($_GET['funktion']){

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
        echo 'ERROR: Något gick fel med parametrarna i eran begäran.';

}


function skapaWiki($conn){

    //-include('dbh.inc.php');

    if(isset($_GET['anvandarId']) && isset($_GET['titel'])){
        $userid = $_GET['anvandarId'];
        $title = $_GET['titel'];
        //var_dump($conn);
        $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
        mysqli_query($conn, $skapaTjanst);
        $skapaWiki = "INSERT INTO wiki(tjanstId) VALUES (". mysqli_insert_id($conn). ")";
    
        if(mysqli_query($conn, $skapaWiki)){
            echo "INFO: Wikin har skapats.";
        } 
        else {
            echo "ERROR: Could not execute $skapaWiki. " . mysqli_error($conn);
        }
    
    }
    $conn->close();

}

function skapaWikiUppdatering($conn){

    //-include('dbh.inc.php');

    if(isset($_GET['wikiId']) && isset($_GET['sidId']) && isset($_GET['bidragsgivare']) &&isset($_GET['titel']) &&isset($_GET['innehall'])){

        //var_dump($conn);
        $wikiId= $_GET['wikiId'];
        $sidId= $_GET['sidId'];
        $bidragsGivare= $_GET['bidragsgivare'];
        $titel= $_GET['titel'];
        $innehall= $_GET['innehall'];

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
                $conn->query($sql);
            }
            else if(($roll=="1" || $roll=="3") && $sidId==$sidaId){
                $sql= "UPDATE wikisidor SET godkantAv='$bidragsGivare',bidragsgivare='$bidragsGivare',titel='$titel',innehall='$innehall',datum='$date' WHERE id=$sidId";
                $conn->query($sql);
            }
            else if(($roll!="1" || $roll!="3") && $sidId==""){
                $sql= "INSERT INTO wikiuppdatering(wikiId, sidId, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$sidId','$bidragsGivare', '$titel','$innehall','$date')";
                $conn->query($sql);
            }
            else{
                $sql= "INSERT INTO wikiuppdatering(wikiId, sidId, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$sidId','$bidragsGivare', '$titel','$innehall','$date')";
                $conn->query($sql);
            }
        
    }
        
    $conn->close();

}

function sokFalt($conn){

    //-include('dbh.inc.php');

    if(isset($_GET['sok'])){
          
        $sok= $_GET['sok'];
    
        $query = mysqli_query($conn,"SELECT * FROM wikisidor WHERE titel LIKE '%$sok%'") or die ("Could not search");
        if($count = mysqli_num_rows($query)){
    
    
    
        }else if($count == 0){
            echo "There was no search results!";
        }

    } 

    $conn->close();

}



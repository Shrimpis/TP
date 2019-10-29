<?php

// Funktioner för att ta bort

session_start();

include('../../Databas/dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'tabortWiki':
                tabortWiki($conn);
                break;
            case 'tabortWikiSida':
                tabortWikiSida($conn);
                break;
            
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }

function tabortWiki($conn){
    //-include('dbh.inc.php');
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

function tabortWikiSida($conn){
    //-include('dbh.inc.php');

    $sidID = $_POST["sidId"];

    $result = ($conn->query("SELECT * FROM wikisidor WHERE id = '{$sidID}'"));
    
    /*while($row = $result->fetch_assoc()){
        $id=$row['id'];
        $godAv=$row['godkantAv'];
        $bidragare=$row['bidragsgivare'];
        $titel = $row['titel'];
        $innehall = $row['innehall'];
        $datum = $row['datum'];

        $sql = "INSERT INTO sidversion(sidID, godkantAv, bidragsgivare, titel, innehall, datum) VALUES ('{$id}', '{$godAv}', '{$bidragare}', '{$titel}', '{$innehall}', '{$datum}')";
        
        $conn->query($sql);
    }*/

    header('Refresh: 2; URL = ../index.php');

    $delSida = "DELETE FROM wikisidor WHERE id = '{$sidID}'";
    $conn->query($delSida);
}


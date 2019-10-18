<?php

session_start();
include("dbh.inc.php");

switch($_POST['funktion']){

    case 'skapaWiki':
        skapaWiki();
        break;
    case 'skapaWikiSida':
        skapaWikiSida();
        break;
    case 'skapaWikiUppdatering':
        skapaWikiUppdatering();
        break;
    default:
        echo 'ERROR: Något gick fel med parametrarna i eran begäran.';

}

$conn->close();

function skapaWikiUppdatering(){

    include("dbh.inc.php");
    if(isset($_POST['sidId']) && isset($_POST['bidragsgivare']) && isset($_POST['titel']) && isset($_POST['innehall'])){

        $sidID = $_POST['sidId'];
        $bidragsgivare = $_POST['bidragsgivare'];
        $titel = $_POST['titel'];
        $innehall = $_POST['innehall'];

    }

    $datum = date("Y-m-d H:i");
    $skapaUppdatering = "INSERT INTO wikiuppdatering(sidId, bidragsgivare, titel, innehall, datum) VALUES('$sidID', '$bidragsgivare', '{$titel}', '{$innehall}', '$datum')";
    mysqli_query($conn, $skapaUppdatering);
    $conn->close();

}



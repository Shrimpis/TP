<?php

// Redigera funktioner //


switch ($_GET['f']) {
    case 'redigeraBlogg':
        redigeraBlogg();
        break;
    case 'redigeraKommentar';
        redigeraKommentar();
        break;
    case 'redigeraTextruta';
        redigeraTextruta();
        break;
    case 'redigeraInlagg';
        redigeraTextruta();
        break;
    default:
        echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
}

function redigeraBlogg(){
    include("dbh.inc.php");

    $Bid = $_GET['BID'];
    $title = $_GET['Titel'];
    $sql = "UPDATE blogg set title = '{$title}' WHERE BID = $Bid ";
    echo $sql;
    $conn->query($sql);
    
    if(mysqli_query($conn, $sql)){
        echo "INFO: Bloggen har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraKommentar(){
    include("dbh.inc.php");

    $Kid = $_GET['KID'];
    $text = $_GET['text'];

    $sql = "UPDATE kommentar set text = '{$text}' WHERE KID = $Kid ";
    $conn->query($sql);

    if(mysqli_query($conn, $sql)){
        echo "INFO: Kommentaren har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraTextruta(){
    $Rid = $_GET['RID'];
    $text = $_GET['Text'];
    $ordning = $_GET['ordning'];
    $sql = "UPDATE textruta set text = '{$text}' WHERE RID = $Rid ";
    $sql = "UPDATE rutor set ordning = $ordning Where RID = $Rid";

    if(mysqli_query($conn, $sql)){
        echo "INFO: Textrutan har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraInlagg(){
    include("dbh.inc.php");

    $iid = $_GET['IID'];
    $title = $_GET['Titel'];
    $sql = "UPDATE blogginlagg set title = '{$title}' WHERE IID = $iid ";
    $conn->query($sql);
    
    if(mysqli_query($conn, $sql)){
        echo "INFO: Inlägget har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
}

?>
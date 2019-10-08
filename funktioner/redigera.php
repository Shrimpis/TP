<?php

// Redigera funktioner //

switch ($_GET['funktion']) {
    case 'redigeraBlogg':
        redigeraBlogg();
        break;
    case 'redigeraKommentar':
        redigeraKommentar();
        break;
    case 'redigeraTextruta':
        redigeraTextruta();
        break;
    case 'redigeraInlagg':
        redigeraTextruta();
        break;
    default:
        echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
}

function redigeraBlogg(){
    include("dbh.inc.php");

    $Bid = $_POST['BID'];
    $title = $_POST['Titel'];
    $uppdateraBlogg = "UPDATE blogg set title = '{$title}' WHERE BID = $Bid ";
    
    if(mysqli_query($conn, $uppdateraBlogg)){
        echo "INFO: Bloggen har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraBlogg. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraKommentar(){
    include("dbh.inc.php");

    $Kid = $_POST['KID'];
    $text = $_POST['text'];

    $uppdateraKommentar = "UPDATE kommentar set text = '{$text}' WHERE KID = $Kid ";

    if(mysqli_query($conn, $uppdateraKommentar)){
        echo "INFO: Kommentaren har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $updateraKommentar. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraTextruta(){
    include("dbh.inc.php");

    $Rid = $_POST['RID'];
    $text = $_POST['Text'];
    $ordning = $_POST['ordning'];
    $uppdateraTextRuta = "UPDATE textruta set text = '{$text}' WHERE RID = $Rid ";
    $uppdateraRuta = "UPDATE rutor set ordning = $ordning Where RID = $Rid";

    if(mysqli_query($conn, $uppdateraTextRuta) && mysqli_query($conn, $uppdateraRuta)){
        echo "INFO: Textrutan har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraTextRuta,$uppdateraRuta. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraInlagg(){
    include("dbh.inc.php");

    $iid = $_POST['IID'];
    $title = $_POST['Titel'];
    $uppdateraInlagg = "UPDATE blogginlagg set title = '{$title}' WHERE IID = $iid ";
    
    if(mysqli_query($conn, $uppdateraInlagg )){
        echo "INFO: InlägPOST har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraInlagg . " . mysqli_error($conn);
    }
    $conn->close();
}

?>
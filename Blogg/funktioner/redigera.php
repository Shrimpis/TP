<?php

// Funktion för redigera //

session_start();
include("dbh.inc.php");
if (isset($_SESSION["licens"]) && isset($_SESSION["anvandare"])) {

    $sql = "SELECT *FROM LICENS WHERE ID =" . $_SESSION["anvandare"];
    $result = $conn->query($sql);
    $result = mysqli_fetch_assoc($result);

    if ($_SESSION["licens"] == $result["licens"]) {
        switch ($_POST['funktion']) {
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
    } else {
        echo "Felaktig/gammal licens. kontakta en adminstratör";
    }
} else {
    echo "Ingen licens. Kontakta adminstratör";
}
$conn->close();

function redigeraBlogg(){
    include("dbh.inc.php");
    if(isset($_POST['BID']) && isset($_POST['Titel'])){
        $Bid = $_POST['BID'];
        $title = $_POST['Titel'];
    }
    $uppdateraBlogg = "UPDATE blogg SET title = '{$title}' WHERE BID = $Bid ";
    
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
    if(isset($_POST['KID']) && isset($_POST['text'])){
        $Kid = $_POST['KID'];
        $text = $_POST['text'];
    }

    $uppdateraKommentar = "UPDATE kommentar SET text = '{$text}' WHERE KID = $Kid ";

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
    if(isset($_POST['RID']) && isset($_POST['text']) && isset($_POST['ordning'])){
        $Rid = $_POST['RID'];
        $text = $_POST['text'];
        $ordning = $_POST['ordning'];
    }
    $uppdateraTextRuta = "UPDATE textruta SET text = '{$text}' WHERE RID = $Rid ";
    $uppdateraRuta = "UPDATE rutor SET ordning = $ordning Where RID = $Rid";

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
    $uppdateraInlagg = "UPDATE blogginlagg SET title = '{$title}' WHERE IID = $iid ";
    
    if(mysqli_query($conn, $uppdateraInlagg )){
        echo "INFO: InlägPOST har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraInlagg . " . mysqli_error($conn);
    }
    $conn->close();
}

?>
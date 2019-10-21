<?php

// Funktion för redigera //

session_start();
include("dbh.inc.php");

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
            case 'privatiseraBlogg':
                privatiseraBlogg();
                break;
            case 'censureraKommentar':
                censureraKommentar();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();

function redigeraBlogg(){
    include("dbh.inc.php");
    if(isset($_POST['BID']) && isset($_POST['Titel'])){
        $Bid = $_POST['BID'];
        $title = $_POST['Titel'];
    }
    $uppdateraBlogg = "UPDATE tjanst SET titel = '{$title}' WHERE id = $Bid ";
    
    if(mysqli_query($conn, $uppdateraBlogg)){
        echo "INFO: Bloggen har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraBlogg. " . mysqli_error($conn);
    }
    $conn->close();
}
function privatiseraBlogg(){
    include("dbh.inc.php");
    if(isset($_POST['bloggid'])&&isset($_POST['privat'])){
        $Bid = $_POST['bloggid'];
        $privat = $_POST['privat'];   
    }
    
    $uppdateraBlogg = "UPDATE tjanst SET privat = '{$privat}' WHERE id = $Bid ";
    
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

    $uppdateraKommentar = "UPDATE kommentar SET innehall = '{$text}' WHERE id = $Kid ";

    if(mysqli_query($conn, $uppdateraKommentar)){
        echo "INFO: Kommentaren har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $updateraKommentar. " . mysqli_error($conn);
    }
    $conn->close();
}

function redigeraInlagg(){
    include("dbh.inc.php");

    $iid = $_POST['IID'];
    $title = $_POST['Titel'];
    $innehall = $_POST['innehall'];
    $uppdateraInlagg = "UPDATE blogginlagg SET titel = '{$title}' innehall = '{$innehall}' WHERE inlaggId = $iid ";
    
    if(mysqli_query($conn, $uppdateraInlagg )){
        echo "INFO: Inlägget har redigerats.";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $uppdateraInlagg . " . mysqli_error($conn);
    }
    $conn->close();
}

function censureraKommentar(){
    include("dbh.inc.php");
    if(isset($_POST['id']) ){
        $id = $_POST['id'];
    }
    $kommentar = $conn->query('select * from kommentar where id ='.$id);

        $row = $kommentar->fetch_assoc();
        $censurerad=$row["censurerad"];
        while($censurerad < 2){
           
            if($censurerad==0){
                $sql= "UPDATE kommentar SET censurerad = '1' WHERE id = $id ";
                $conn->query($sql);
                echo "INFO: Kommentaren är nu public.";
                break;
               
            }
            else if($censurerad==1){
                $sql= "UPDATE kommentar SET censurerad = '0' WHERE id = $id ";
                $conn->query($sql);
                echo "INFO: Kommentaren är nu privat.";
               break;
            }
            else{
                echo "ERROR: kommentar typ måste vara mellan 0 och 1. " . mysqli_error($conn);
               break;
            }
        }
        
    
    $conn->close();
}

?>
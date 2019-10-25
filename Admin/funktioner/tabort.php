<?php 

session_start();
include("../../Databas/dbh.inc.php");

    switch ($_POST['funktion']) {
        case 'tabortKonto':
            tabortKonto($conn);
            break;
        case 'harddelkonto':
            harddelkonto($conn);
            break;
        default:
            echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
    }
    
 
$conn->close();

function tabortKonto($conn){
    //-include("../../Databas/dbh.inc.php");
    $UID = mysqli_real_escape_string($conn, $_POST['anvandarid']);
    $delkonto = "UPDATE anvandare SET aktiv = false WHERE id='{$UID}'";
    
    
    if(mysqli_query($conn, $delkonto)){
        echo "INFO: konto avaktiverat";
        header('Refresh: 2; URL = ../kontoformsadmin.php');
    } else {
        echo "ERROR: Could not execute $delkonto. " . mysqli_error($conn);
    }

    $conn->close();

}
function harddelkonto($conn){
    //-include("../../Databas/dbh.inc.php");
    $id = mysqli_real_escape_string($conn, $_POST['kontoID']);
    $kundID = $id = mysqli_real_escape_string($conn, $_POST['id']);
    $delkonto = "DELETE FROM anvandare WHERE id ='{$id}'";
    $delroll = "DELETE FROM anvandarroll WHERE anvandarId ='{$id}'";
    $deltjans = "DELETE FROM tjanst WHERE anvandarId ='{$id}'";
    $delkom = "DELETE FROM kommentar WHERE anvandarId ='{$id}'";
    $delgil = "DELETE FROM gillningar WHERE anvandarId ='{$id}'";

    $aktiv = '0';    
    $conn->query("UPDATE kundrattigheter SET tjanst = $aktiv, superadmin = $aktiv, kontoID = $aktiv WHERE id = $kundID");

    $result = $conn->query("SELECT id from tjanst where anvandarId = '{$id}'");
    if(mysqli_num_rows($result) > 0){
        while($row=$result->fetch_assoc()){
            $delid = $row['id'];
            $conn->query("DELETE FROM blogginlagg where bloggId = '{$delid}'");
            $conn->query("DELETE FROM blogg WHERE id = '{$delid}'");
            $conn->query("DELETE FROM wiki WHERE id = '{$delid}'");
            $conn->query("DELETE FROM kalender WHERE id = '{$delid}'");
        }
    }
    
    
    if(mysqli_query($conn, $delkonto)&&mysqli_query($conn, $delroll)&&mysqli_query($conn, $deltjans)&&mysqli_query($conn, $delkom)&&mysqli_query($conn, $delgil)){
        header('location: ../index.php?funktion=avslutaKonto?status=success');
    } else {
        echo "ERROR: Could not execute $delkonto. " . mysqli_error($conn);
    }

    $conn->close();

}
?>
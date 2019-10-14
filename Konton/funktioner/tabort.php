<?php 

session_start();
include("dbh.inc.php");




    
        switch ($_POST['funktion']) {
            case 'skapaKonto':
                skapaKonto();
                break;
            case 'skapaInlagg':
                skapaInlagg();
                break;
            case 'skapaTextruta':
                skapaTextruta();
                break;
            case 'skapaBildRuta':
                skapaBildRuta();
                break;
            case 'skapaKommentar':
                skapaKommentar();
                break;
            case 'gillaInlagg':
                gillaInlagg();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function tabortKonto(){
    
    $UID = mysqli_real_escape_string($conn, $_POST['UID']);
    $delkonto = "DELETE FROM anvandare WHERE UID='{$UID}'";
    $delroll = "DELETE FROM anvandaroll WHERE anvandarid='{$UID}'";
    
    if(mysqli_query($conn, $delkonto)&&mysqli_query($conn, $delroll)){
        echo "INFO: konto borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $delkonto,$delroll. " . mysqli_error($conn);
    }

    $conn->close();

}
?>
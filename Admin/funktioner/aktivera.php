<?php 

include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'aktiveraTjanst':
                aktiveraTjanst();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
 
$conn->close();

function aktiveraTjanst(){
    include("dbh.inc.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']); //Kund-ID
    $tjanst = (isset($_POST['CheckTjanst'])) ? 1 : 0;

    $aktivera = "INSERT INTO kundrattigheter(id,tjanst, superadmin, kontoId) VALUES ($id ,$tjanst, '0', '0')";

    if(mysqli_query($conn, $aktivera)){
        header('location: ../index.php?funktion=aktiveraTjanst?m=success');
    } else {
        echo "ERROR: Could not able to execute $aktivera. " . mysqli_error($conn);
    }

}

?>
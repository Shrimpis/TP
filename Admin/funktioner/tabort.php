<?php 

session_start();
include("../../Databas/dbh.inc.php");
include("../../json/felhantering.php");

    switch ($_POST['funktion']) {
        case 'tabortKonto':
            tabortKonto($conn);
            break;
        case 'harddelkonto':
            harddelkonto($conn);
            break;
        default:
            hantering('400','ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.');
            break;
    }
    
  
function tabortKonto($conn){
    //-include("../../Databas/dbh.inc.php");
    $UID = mysqli_real_escape_string($conn, $_POST['anvandarid']);
    $delkonto = "UPDATE anvandare SET aktiv = false WHERE id='{$UID}'";
    
    
    if(mysqli_query($conn, $delkonto)){
        hantering('202','konto avaktiverat');
    } else {
        hantering('400','kunde inte exekvera');
    }

    $conn->close();

}
function harddelkonto($conn){
    echo "hej";
    //-include("../../Databas/dbh.inc.php");
    $id = mysqli_real_escape_string($conn, $_POST['kontoID']);
    // $kundID = $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    $delkonto = "DELETE FROM anvandare WHERE id ='{$id}'";
    $delroll = "DELETE FROM anvandarroll WHERE anvandarId ='{$id}'";
    $deltjans = "DELETE FROM tjanst WHERE anvandarId ='{$id}'";
    $delkom = "DELETE FROM kommentar WHERE anvandarId ='{$id}'";
    $delgil = "DELETE FROM gillningar WHERE anvandarId ='{$id}'";
    $delflagb = "DELETE FROM flaggadblogg WHERE anvandarId = $id";
    $delflagk = "DELETE FROM flaggadkommentar WHERE anvandarId = $id";

    // $aktiv = '0';    
    // mysqli_query($conn,"UPDATE kundrattigheter SET tjanst = $aktiv, superadmin = $aktiv, kontoID = $aktiv WHERE id = $kundID");
    // echo mysqli_error($conn);
    $result = mysqli_query($conn,"SELECT id from tjanst where anvandarId = '{$id}'");
    echo mysqli_error($conn);
    if(mysqli_num_rows($result) > 0){
        while($row=$result->fetch_assoc()){
            $delid = $row['id'];
            $result = mysqli_query($conn,"SELECT * FROM anvandarroll WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            while($row = $result->fetch_assoc()){
                $delrol = $row['anvandarId'];
                mysqli_query($conn,"DELETE FROM anvandare where id = '{$delrol}'");
                echo mysqli_error($conn);
            }
            mysqli_query($conn,"DELETE FROM anvandarroll where tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            $result = mysqli_query($conn,"SELECT * FROM blogg WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            while($row = $result->fetch_assoc()){
                $bid = $row['id'];
                mysqli_query($conn,"DELETE FROM blogginlagg where bloggId = '{$bid}'");
                echo mysqli_error($conn);
            }
            mysqli_query($conn,"DELETE FROM blogg WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            $result = mysqli_query($conn,"SELECT * FROM wiki WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            while($row = $result->fetch_assoc()){
                $wid = $row['id'];
                mysqli_query($conn,"DELETE FROM wikisidor WHERE wikiId = '{$wid}'");
                echo mysqli_error($conn);
                mysqli_query($conn,"DELETE FROM wikiuppdatering WHERE wikiId = '{$wid}'");
                echo mysqli_error($conn);
                mysqli_query($conn,"DELETE FROM nekadwikiuppdatering WHERE wikiId = '{$wid}'");
                echo mysqli_error($conn);
            }
            mysqli_query($conn,"DELETE FROM wiki WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            $result = mysqli_query($conn,"SELECT * FROM kalender WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
            while($row = $result->fetch_assoc()){
                $kid = $row['id'];
                $result = mysqli_query($conn,"SELECT * FROM kalendersida WHERE kalenderId = '{$kid}'");
                echo mysqli_error($conn);
                while($row = $result->fetch_assoc()){
                    $delkalevid = $row['id'];
                    $result = mysqli_query($conn,"SELECT * FROM kalenderevent WHERE kalenderId = '{$delkalevid}'");
                    echo mysqli_error($conn);
                        while($row = $result->fetch_assoc()){
                            $delevid = $row['eventId'];
                            mysqli_query($conn,"DELETE FROM event WHERE id = '{$delevid}'");
                            echo mysqli_error($conn);
                        }
                    mysqli_query($conn,"DELETE FROM kalenderevent WHERE kalenderId = '{$delkalevid}'");
                    echo mysqli_error($conn);
                }
                mysqli_query($conn,"DELETE FROM kalendersida WHERE kalenderId = '{$kid}'"); 
                echo mysqli_error($conn);
            }
            mysqli_query($conn,"DELETE FROM kalender WHERE tjanstId = '{$delid}'");
            echo mysqli_error($conn);
        }
    }
    
    
    if(mysqli_query($conn, $delkonto)&&mysqli_query($conn, $delroll)&&mysqli_query($conn, $deltjans)&&mysqli_query($conn, $delkom)&&mysqli_query($conn, $delgil)&&mysqli_query($conn, $delflagb)&&mysqli_query($conn, $delflagk)){
        // header('location: ../index.php?funktion=avslutaKonto?status=success');
    } else {
        // hantering('400','fel');
        echo mysqli_error($conn);
    }

    $conn->close();

}
?>
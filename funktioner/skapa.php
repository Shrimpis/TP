<?php
session_start();
include("dbh.inc.php");
if (isset($_SESSION["licens"]) && isset($_SESSION["anvandare"])) {

    $sql = "SELECT *FROM LICENS WHERE ID =" . $_SESSION["anvandare"];
    $result = $conn->query($sql);
    $result = mysqli_fetch_assoc($result);

    if ($_SESSION["licens"] == $result["licens"]) {
        switch ($_POST['funktion']) {
            case 'skapaBlogg':
                skapaBlogg();
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
    } else {
        echo "Felaktig/gammal licens. kontakta en adminstratör";
    }
} else {
echo "Ingen licens. Kontakta adminstratör";
}
$conn->close();

    function skapaBlogg(){

        include("dbh.inc.php");
        if(isset($_POST['UID']) && isset($_POST['Titel'])){
            $userid = $_POST['UID'];
            $title = $_POST['Titel'];
            $skapaBlogg = "INSERT INTO blogg(title,UID) VALUES('{$title}',$userid)";
            $conn->query($skapaBlogg);
            $conn->close();
        }
        if(mysqli_query($conn, $skapaBlogg)){
            echo "INFO: Bloggen har skapats.";
            header('Refresh: 2; URL = ../index.php');
        } else {
            echo "ERROR: Could not execute $skapaBlogg. " . mysqli_error($conn);
        }
        $conn->close();

    }

    function skapaInlagg(){

        include("dbh.inc.php");
        if(isset($_POST['BID']) && isset($_POST['title'])){
            $blogID= $_POST['BID'];
            $title= $_POST['title'];
        }

        $date= date("Y-m-d H:i");
        $sql= "INSERT INTO blogginlagg(BID, datum, title) VALUES ('$blogID','$date','$title')";
        $conn->query($sql);
        $conn->close();

    }

    function skapaTextRuta(){

        include('dbh.inc.php');
        if(isset($_POST['text']) && isset($_POST['rubrik']) && isset($_POST['IID']) && isset($_POST['ordning'])){
            $text= $_POST['text'];
            $rubrik= $_POST['rubrik'];
            $IID= $_POST['IID'];
            $ordning= $_POST['ordning'];
        }else if(isset($_POST['text']) && isset($_POST['IID']) && isset($_POST['ordning'])){
            $text= $_POST['text'];
            $IID= $_POST['IID'];
            $ordning= $_POST['ordning'];
        }

        $sql= "INSERT INTO rutor(ordning, IID) VALUES ('$ordning','$IID')";
        $conn->query($sql);
        $rutaID= mysqli_insert_id($conn);
        $sql= "INSERT INTO textruta(RID, text, rubrik, IID) VALUES ('$rutaID','$text','$rubrik','$IID')";
        $conn->query($sql);
        $conn->close();


    }

    function skapaBildRuta(){

        include('dbh.inc.php');
        $mal_dir = "bilder/";
        $mal_fil = $mal_dir . basename($_FILES["bildRuta"]["name"]);
        $uppladningOk = 1;
        $bildFilTyp = strtolower(pathinfo($mal_fil,PATHINFO_EXTENSION));       
        if(!file_exists($mal_dir)){
            mkdir($mal_fil,0777,true);
        }
        if(isset($_POST["submit"])){
            $kontroll = getimagesize($_FILES["bildRuta"]["tmp_name"]);
            
            if($kontroll !== false){
                
                $uppladningOk = 1;
            }else{
                $uppladningOk  = 0;
            }
            
        }
        //om filen redan finns
        if(file_exists($mal_fil)){
            $uppladningOk = 0;
            echo "shit";
        }
        //Max storlek på bild
        if($_FILES["bildRuta"]["size"] > 500000){
            
            $uppladningOk = 0;
            
        }
        //Kollar så att det är giltiga fil extensions
        if($bildFilTyp != "jpg" && $bildFilTyp != "png" && $bildFilTyp != "gif" && $bildFilTyp != "jpeg"){
            $uppladningOk = 0;
            echo "fel bild format";
        }
        //kollar om det dök upp något fel annars går den vidare
        if($uppladningOk == 0){
            echo "FEL";
        }else{
            if(move_uploaded_file($_FILES["bildRuta"]["tmp_name"], $mal_fil)){
                
                $sql = "INSERT INTO rutor(IID,ordning) VALUES(1,1)";
                $conn->query($sql);
                $RID = mysqli_insert_id($conn);
                
                $sql= "INSERT INTO bildRuta(RID,bildPath,IID) VALUES($RID,'$mal_fil',1)";
                
                $conn->query($sql);
                
                
                echo "gick";
            }else{
                echo "fel";
            }
        }

        $conn->close();

    }

    function skapaKommentar(){

        include('dbh.inc.php');
        if(isset($_POST['UID']) && isset($_POST['IID']) && isset($_POST['text']) && isset($_POST['hierarchyID'])){
            $UID = mysqli_real_escape_string($conn, $_POST['UID']); //Användar-ID
            $IID = mysqli_real_escape_string($conn, $_POST['IID']); //Blogginlägg-ID
            $text = mysqli_real_escape_string($conn, $_POST['text']); //Kommentar text
            $hierarchyID = mysqli_real_escape_string($conn, $_POST['hierarchyID']);
        }
        $skapaKommentar = "INSERT INTO kommentar (UID, IID, text, hierarchyID) VALUES ('$UID', '$IID', '{$text}', '$hierarchyID')";
        if(mysqli_query($conn, $skapaKommentar)){
            echo "INFO: Kommentar skapad.";
        } else{
            echo "ERROR: Could not able to execute $skapaKommentar. " . mysqli_error($conn);
        }
        $conn->close();

    }

    function gillaInlagg(){

        include('dbh.inc.php');
        if(isset($_POST['UID']) && isset($_POST['IID'])){
            $UID = mysqli_real_escape_string($conn, $_POST['UID']); //Användar-ID
            $IID = mysqli_real_escape_string($conn, $_POST['IID']); //Blogginlägg-ID
        }
        $redan_gillat = mysqli_query($conn, "SELECT UID, IID FROM gillningar WHERE UID='$UID' AND IID='$IID'");

        if($redan_gillat->num_rows == 0){
            $like = "INSERT INTO gillningar (UID, IID) VALUES ('$UID', '{$IID}')";
            if(mysqli_query($conn, $like)){
                echo "INFO: Inlägg med id " .$IID. " gillat av användar med id " .$UID. ".";
            } else{
                echo "ERROR: Could not able to execute $like. " . mysqli_error($conn);
            }
        } else {
            $dislike = "DELETE FROM gillningar WHERE UID='$UID' AND IID='$IID'";
            if(mysqli_query($conn, $dislike)){
                echo "ERROR: Användaren har redan gillat. Tar bort gillning.";
            } else{
                echo "ERROR: Could not able to execute $dislike. " . mysqli_error($conn);
            }
        }

        header("location: ../index.php");
        $conn->close();

    }

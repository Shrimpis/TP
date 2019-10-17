<?php

// Funktion för skapa //

session_start();
include("dbh.inc.php");

    
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
            case 'flaggaBlogg':
                flaggaBlogg();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
    

$conn->close();

    function skapaBlogg(){

        include("dbh.inc.php");
        if(isset($_POST['UID']) && isset($_POST['Titel'])){
            $userid = $_POST['UID'];
            $title = $_POST['Titel'];
            $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
            mysqli_query($conn, $skapaTjanst);
            $skapaBlogg = "INSERT INTO blogg(tjanstId) VALUES (". mysqli_insert_id($conn). ")";
            //$skapaBlogg = "INSERT INTO blogg(title, UID) VALUES('{$title}',$userid)";
            
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
            $innehall= $_POST['innehall'];
        }

        $date= date("Y-m-d H:i");
        $sql= "INSERT INTO blogginlagg(bloggId, titel, innehall, datum) VALUES ('$blogID','$title','$innehall','$date')";
        $conn->query($sql);
        $conn->close();

    }

    //Bilder blev utesluten från databasen och därför funkar inte denna funktion ännu.
    /*function skapaBild(){

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

    }*/

    function skapaKommentar(){

        include('dbh.inc.php');
        if(isset($_POST['UID']) && isset($_POST['IID']) && isset($_POST['text']) && isset($_POST['hierarchyID'])){
            $UID = mysqli_real_escape_string($conn, $_POST['UID']); //Användar-ID
            $IID = mysqli_real_escape_string($conn, $_POST['IID']); //Blogginlägg-ID
            $text = mysqli_real_escape_string($conn, $_POST['text']); //Kommentar text
            $hierarchyID = mysqli_real_escape_string($conn, $_POST['hierarchyID']);
        }
        $skapaKommentar = "INSERT INTO kommentar (användarId, inlaggId, hierarkiId, innehall) VALUES ('$UID', '$IID', '$hierarchyID', '{$text}')";
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
        $redan_gillat = mysqli_query($conn, "SELECT anvandarId, inlaggId FROM gillningar WHERE anvandarId='$UID' AND inlaggId='$IID'");

        if($redan_gillat->num_rows == 0){
            $like = "INSERT INTO gillningar(anvandarId, inlaggId) VALUES ('$UID', '{$IID}')";
            if(mysqli_query($conn, $like)){
                echo "INFO: Inlägg med id " .$IID. " gillat av användar med id " .$UID. ".";
            } else{
                echo "ERROR: Could not able to execute $like. " . mysqli_error($conn);
            }
        } else {
            $dislike = "DELETE FROM gillningar WHERE anvandarId='$UID' AND inlaggId='$IID'";
            if(mysqli_query($conn, $dislike)){
                echo "ERROR: Användaren har redan gillat. Tar bort gillning.";
            } else{
                echo "ERROR: Could not able to execute $dislike. " . mysqli_error($conn);
            }
        }

        header("location: ../index.php");
        $conn->close();

    }
    function flaggaBlogg(){
        include('dbh.inc.php');
        if(isset($_POST['bloggid']) && isset($_POST['anvandarID'])){
            $Bloggid = $_POST['bloggid']; 
            $anvandarId = $_POST['anvandarID']; 
        }
        $redan_flaggat = mysqli_query($conn, "SELECT anvandarId FROM flaggadblogg WHERE anvandarId='$anvandarId' AND bloggId='$Bloggid'");


        if($redan_flaggat->num_rows == 0){
            $flagga = "INSERT INTO flaggadblogg(anvandarId, bloggId) VALUES ('{$anvandarId}', '{$Bloggid}')";
            $conn->query($flagga);
        }
        
        /*
        om denna del inte är bortkommenterad tas flaggan bort om man anropar funktionen igen med samma värden.
        else{
            $avflagga = "DELETE FROM flaggadblogg WHERE anvandarId='$anvandarId' AND bloggId='$Bloggid'";
            $conn->query($avflagga);
        }
        */
        
        
        header("Location: ../index.php");
        $conn->close();

    }
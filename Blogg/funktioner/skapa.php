<?php

// Funktion för skapa //

session_start();
include("../../Databas/dbh.inc.php");
include("../../json/felhantering.php");
    
        switch ($_POST['funktion']) {
            case 'skapaBlogg':
                skapaBlogg($conn);
                break;
            case 'skapaInlagg':
                skapaInlagg($conn);
                break;
            case 'skapaKommentar':
                skapaKommentar($conn);
                break;
            case 'skapaSokning':
                skapaSokning($conn);
                break;
            case 'gillaInlagg':
                gillaInlagg($conn);
                break;
            case 'flaggaBlogg':
                flaggaBlogg($conn);
                break;
            case 'flaggaKommentar':
                flaggaKommentar($conn);
                break;
            case 'sokfalt':
                sokFalt($conn);
                break;
            default:
                hantering('400','Din förfrågan är utanför våra parametrar, kolla dokumentationen',);
        }
    
    
 

    function skapaBlogg($conn){

       //- include("../../Databas/dbh.inc.php");
        if(isset($_POST['anvandarId']) && isset($_POST['Titel'])){
            $userid = $_POST['anvandarId'];
            $title = $_POST['Titel'];
            $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
            $skapaBlogg = "INSERT INTO blogg(tjanstId) VALUES (". mysqli_insert_id($conn). ")";

            
            
        }
        if(mysqli_query($conn, $skapaTjanst)){

            hantering('200','Tjänsten har skapats',);

        } else {

            hantering('400','Tjänsten kunde inte skapas',);

        }
        if(mysqli_query($conn, $skapaBlogg)){

            hantering('200','Bloggen har skapats',);

        }else{

            hantering('400','Bloggen kunde inte skapas',);

        }
        $conn->close();

    }

    function skapaInlagg($conn){

        //-include("../../Databas/dbh.inc.php");
        if(isset($_POST['bloggId']) && isset($_POST['Title'])){
            $bloggID= $_POST['bloggId'];
            $title= $_POST['Title'];
            $innehall= $_POST['innehall'];
        }

        $date= date("Y-m-d H:i");
        $sql= "INSERT INTO blogginlagg(bloggId, titel, innehall, datum) VALUES ('$bloggID','$title','$innehall','$date')";
        
        if(mysqli_query($conn, $sql)){

            hantering('200','Blogginlägget har skapats',);
            
        } else {

            hantering('400','Bloginlägget kunde inte skapas',);
            
        }
        
        $conn->close();

    }

    function skapaKommentar($conn){

        //-include("../../Databas/dbh.inc.php");
        if(isset($_POST['anvandarId']) && isset($_POST['inlaggsId']) && isset($_POST['text']) && isset($_POST['hierarchyID'])){
            $anvandarId = mysqli_real_escape_string($conn, $_POST['anvandarId']); //Användar-ID
            $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']); //Blogginlägg-ID
            $text = mysqli_real_escape_string($conn, $_POST['text']); //Kommentar text
            $hierarchyID = mysqli_real_escape_string($conn, $_POST['hierarchyID']);
        }
        $skapaKommentar = "INSERT INTO kommentar (anvandarId, inlaggId, hierarkiId, innehall) VALUES ('$anvandarId', '$inlaggsId', '$hierarchyID', '{$text}')";
        if(mysqli_query($conn, $skapaKommentar)){

            hantering('200','Kommentar har skapats',);

        } else{

            hantering('400','Kommentar kunde inte skapas',);
            
        }
        $conn->close();

    }


    function sokFalt($conn){
        if(isset($_POST['sok'])){
            $sok= $_POST['sok'];
        } 
        $output = '';

        $query = mysqli_query($conn,"SELECT * FROM blogginlagg WHERE titel LIKE '%$sok%'") or die ("Could not search");
        $count = mysqli_num_rows($query);

        if($count == 0){
            $output = "There was no search results!";
        }
        else{
           while ($row = mysqli_fetch_array($query)) {
                $title = $row ['titel'];
                
                $output ='<div> '.$title.'</div>';
                print ($output);
            }
            hantering('200','Din förfrågan lyckades',);
        }
        $conn->close();
    }

    function gillaInlagg($conn){

        //-include("../../Databas/dbh.inc.php");
        if(isset($_POST['anvandarId']) && isset($_POST['inlaggsId'])){
            $anvandarId = mysqli_real_escape_string($conn, $_POST['anvandarId']); //Användar-ID
            $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']); //Blogginlägg-ID
        }
        $redan_gillat = mysqli_query($conn, "SELECT anvandarId, inlaggId FROM gillningar WHERE anvandarId='$anvandarId' AND inlaggId='$inlaggsId'");

        if($redan_gillat->num_rows == 0){
            $like = "INSERT INTO gillningar(anvandarId, inlaggId) VALUES ('$anvandarId', '{$inlaggsId}')";
            if(mysqli_query($conn, $like)){

                hantering('200','Inlägget har gillats',);

            } else{

                hantering('400','Inlägget kunde inte gillas',);

            }
        } else {
            $dislike = "DELETE FROM gillningar WHERE anvandarId='$anvandarId' AND inlaggId='$inlaggsId'";
            if(mysqli_query($conn, $dislike)){

                hantering('200','Inlägget gillas inte längre',);

            } else{

                hantering('400','Kunde inte ångra gilla statusen på inlägget',);

            }
        }

        $conn->close();

    }
    function flaggaBlogg($conn){
        //-include("../../Databas/dbh.inc.php");
        if(isset($_POST['bloggid']) && isset($_POST['anvandarID'])){
            $Bloggid = $_POST['bloggid']; 
            $anvandarId = $_POST['anvandarID']; 
        }
        $redan_flaggat = mysqli_query($conn, "SELECT anvandarId FROM flaggadblogg WHERE anvandarId='$anvandarId' AND bloggId='$Bloggid'");


        if($redan_flaggat->num_rows == 0){
            $flagga = "INSERT INTO flaggadblogg(anvandarId, bloggId) VALUES ('{$anvandarId}', '{$Bloggid}')";
            $conn->query($flagga);

            hantering('200','Bloggen flaggades',);

        }else{

            hantering('400','Kunde inte flagga bloggen',);

        }
        
        /*
        om denna del inte är bortkommenterad tas flaggan bort om man anropar funktionen igen med samma värden.
        else{
            $avflagga = "DELETE FROM flaggadblogg WHERE anvandarId='$anvandarId' AND bloggId='$Bloggid'";
            $conn->query($avflagga);
        }
        */
        
        $conn->close();

    }
    function flaggaKommentar($conn){
        //-include('dbh.inc.php');
        if(isset($_POST['kommentarsid']) && isset($_POST['anvandarID'])){
            $komid = $_POST['kommentarsid']; 
            $anvandarId = $_POST['anvandarID']; 
        }
        $redan_flaggat = mysqli_query($conn, "SELECT anvandarId FROM flaggadkommentar WHERE anvandarId='$anvandarId' AND kommentarId='$komid'");


        if($redan_flaggat->num_rows == 0){
            $flagga = "INSERT INTO flaggadkommentar(anvandarId, kommentarId) VALUES ('{$anvandarId}', '{$komid}')";
            $conn->query($flagga);

            hantering('200','Kommentaren flaggades',);

        } else {

            hantering('400','Kommentaren kunde inte flaggas',);

        }
        
        /*
        om denna del inte är bortkommenterad tas flaggan bort om man anropar funktionen igen med samma värden.
        else{
            $avflagga = "DELETE FROM flaggadkommentar WHERE anvandarId='$anvandarId' AND kommentarId='$komid'";
            $conn->query($avflagga);
        }
        */
        $conn->close();

    }
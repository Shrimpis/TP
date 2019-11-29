<?php
// Funktion för skapa //

//session_start();
include("../../Databas/dbh.inc.php");
include("../../json/felhantering.php");
//if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom
    //var_dump($_POST['nyckel']);
    
   /* $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
    $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);*/

    //if($count == 1){
       /* switch ($_POST['funktion']) {
            
            case 'skapaBlogg':
                skapaBlogg($conn);
                break;
            case 'skapaBlogg2':
                skapaBlogg2($conn);
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
                hantering('404','Din förfrågan är utanför våra parametrar, kolla dokumentationen');
        }*/
    /*}
    else{
        hantering('401','Behörighet saknas');
    }*/
/*}
else{
    hantering('401','Behörighet saknas, tom api');
}*/
 

    function skapaBlogg($conn){

       //- include("../../Databas/dbh.inc.php");
        if(isset($_POST['anvandarId']) && isset($_POST['Titel'])){

            $userid = $_POST['anvandarId'];
            $title = $_POST['Titel'];
            $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
            
            
        }
        if(mysqli_query($conn, $skapaTjanst)){

            //hantering('201','Tjänsten har skapats',);
            $skapaBlogg = "INSERT INTO blogg(tjanstId) VALUES (". mysqli_insert_id($conn). ")";
            if(mysqli_query($conn, $skapaBlogg)){

               // hantering('201','Bloggen har skapats');
    
            }else{
    
               // hantering('400','Bloggen kunde inte skapas');
    
            }
        } else {

            //hantering('400','Tjänsten kunde inte skapas');

        }
        
        $conn->close();

    }

/*
    function skapaBlogg2($conn){

        //- include("../../Databas/dbh.inc.php");
         if(isset($_POST['anvandarId']) && isset($_POST['Titel']) && isset($_POST['bloggAnvandarId'])){
 
             $userid = $_POST['anvandarId'];
             $title = $_POST['Titel'];
             $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
             
             
             $bloggUserId = $_POST['bloggAnvandarId'];//bloggens ägare
         }
         if(mysqli_query($conn, $skapaTjanst)){
 
             hantering('201','Tjänsten har skapats');
             $skapaBlogg = "INSERT INTO blogg(tjanstId,anvandarID) VALUES (".mysqli_insert_id($conn). ",".$bloggUserId.")";
             if(mysqli_query($conn, $skapaBlogg)){
 
                 hantering('201','Bloggen har skapats');
     
             }else{
     
                 hantering('400','Bloggen kunde inte skapas');
     
             }
         } else {
 
             hantering('400','Tjänsten kunde inte skapas');
 
         }
         
         $conn->close();
 
     }

*/


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

            hantering('201','Blogginlägget har skapats');
            
        } else {

            hantering('400','Bloginlägget kunde inte skapas');
            
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

            hantering('201','Kommentar har skapats');

        } else{

            hantering('400','Kommentar kunde inte skapas');
            
        }
        $conn->close();

    }


    function sokFalt($conn){
        if(isset($_POST['sok']) && isset($_POST['bloggId'])){
            $sok= $_POST['sok'];
            $bloggId= $_POST['bloggId'];
        } 
        $output = '';

        $query = mysqli_query($conn,"SELECT * FROM blogginlagg WHERE titel LIKE '%$sok%'") or die ("Could not search");
        $count = mysqli_num_rows($query);

        if($count == 0){
            $output = "There was no search results!";
        }
        else{
            $i=0;
            $inlagg=array();
            while ($row = mysqli_fetch_array($query)) {
               if($row['bloggId']==$bloggId){
                    $title = $row ['titel'];
                    $inlagg[$i]=$title;
                    $i++;
               }
            }
            $json=json_encode($inlagg);
            echo $json;
            //hantering('200','Din förfrågan lyckades',);
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

                hantering('201','Inlägget har gillats');

            } else{

                hantering('400','Inlägget kunde inte gillas');

            }
        } else {
            $dislike = "DELETE FROM gillningar WHERE anvandarId='$anvandarId' AND inlaggId='$inlaggsId'";
            if(mysqli_query($conn, $dislike)){

                hantering('204','Inlägget gillas inte längre');

            } else{

                hantering('400','Kunde inte ångra gilla statusen på inlägget');

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

            hantering('201','Bloggen flaggades');

        }else{

            hantering('400','Kunde inte flagga bloggen');

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

            hantering('201','Kommentaren flaggades');

        } else {

            hantering('400','Kommentaren kunde inte flaggas');

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


    ?>
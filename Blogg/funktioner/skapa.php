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
            case 'skapaTextruta': //Ta bort
                skapaTextruta();
                break;
            case 'skapaBildRuta': //Ta bort
                skapaBildRuta();
                break;
            case 'skapaKommentar':
                skapaKommentar();
                break;
            case 'skapaSokning':
                skapaSokning();
                break;
            case 'gillaInlagg':
                gillaInlagg();
                break;
            case 'flaggaBlogg':
                flaggaBlogg();
                break;
            case 'flaggaKommentar':
                flaggaKommentar();
                break;
            case 'sokfalt':
                sokFalt();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
    

$conn->close();

    function skapaBlogg(){

        include("dbh.inc.php");
        if(isset($_POST['anvandarId']) && isset($_POST['Titel'])){
            $userid = $_POST['anvandarId'];
            $title = $_POST['Titel'];
            $skapaTjanst = "INSERT INTO tjanst(titel, anvandarId, privat) VALUES('{$title}',$userid,0)";
            mysqli_query($conn, $skapaTjanst);
            $skapaBlogg = "INSERT INTO blogg(tjanstId) VALUES (". mysqli_insert_id($conn). ")";

            
            
        }
        if(mysqli_query($conn, $skapaBlogg) && mysqli_query($conn, $skapaTjanst)){

            $skapaBloggJson = array(
                'code'=> '201',
                'status'=> 'Created',
                'msg' => 'Blogg created',
                'blogg' => array(
                    'userid'=>$userid,
                    'title'=>$title,
                    'privat'=> '0'
                )
            );

            echo json_encode($skapaBloggJson);

        } else {

            $skapaBloggJsonError = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Could not execute',
                'blogg' => array(
                    'userid'=>$userid,
                    'title'=>$title,
                    'privat'=> '0'
                )
            );

            echo json_encode($skapaBloggJsonError);

        }
        $conn->close();

    }

    function skapaInlagg(){

        include("dbh.inc.php");
        if(isset($_POST['bloggId']) && isset($_POST['title'])){
            $blogID= $_POST['bloggId'];
            $title= $_POST['title'];
            $innehall= $_POST['innehall'];
        }

        $date= date("Y-m-d H:i");
        $sql= "INSERT INTO blogginlagg(bloggId, titel, innehall, datum) VALUES ('$blogID','$title','$innehall','$date')";
        
        if(mysqli_query($conn, $sql)){
            $skapaInlaggJson = array(
                'code'=> '201',
                'status'=> 'Created',
                'msg' => 'Post created',
                'post' => array(
                    'blogid'=>$blogID,
                    'title'=>$title,
                    'content'=>$innehall,
                    'date'=>$date
                )
            );
            
            echo json_encode($skapaInlaggJson);
        } else {
            $skapaInlaggJsonError = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Could not execute',
                'post' => array(
                    'blogid'=>$blogID,
                    'title'=>$title,
                    'content'=>$innehall,
                    'date'=>$date
                )
            );
            
            echo json_encode($skapaInlaggJsonError);
        }
        
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
                
                $sql = "INSERT INTO rutor(inlaggsId,ordning) VALUES(1,1)";
                $conn->query($sql);
                $RID = mysqli_insert_id($conn);
                
                $sql= "INSERT INTO bildRuta(RID,bildPath,inlaggsId) VALUES($RID,'$mal_fil',1)";
                
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
        if(isset($_POST['anvandarId']) && isset($_POST['inlaggsId']) && isset($_POST['text']) && isset($_POST['hierarchyID'])){
            $anvandarId = mysqli_real_escape_string($conn, $_POST['anvandarId']); //Användar-ID
            $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']); //Blogginlägg-ID
            $text = mysqli_real_escape_string($conn, $_POST['text']); //Kommentar text
            $hierarchyID = mysqli_real_escape_string($conn, $_POST['hierarchyID']);
        }
        $skapaKommentar = "INSERT INTO kommentar (användarId, inlaggId, hierarkiId, innehall) VALUES ('$anvandarId', '$inlaggsId', '$hierarchyID', '{$text}')";
        if(mysqli_query($conn, $skapaKommentar)){
            $skapaKommentarJson = array(
                'code'=> '201',
                'status'=> 'Created',
                'msg' => 'Comment created',
                'comment' => array(
                    'userid'=>$anvandarId,
                    'postid'=>$inlaggsId,
                    'text'=>$text,
                    'hierarchyID'=>$hierarchyID
                )
            );
            
            echo json_encode($skapaKommentarJson);
        } else{
            $skapaKommentarJsonError = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Could not executed',
                'comment' => array(
                    'userid'=>$anvandarId,
                    'postid'=>$inlaggsId,
                    'text'=>$text,
                    'hierarchyID'=>$hierarchyID
                )
            );
            
            echo json_encode($skapaKommentarJsonError);
        }
        $conn->close();

    }


    function sokFalt(){
        include("dbh.inc.php");
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
        }
        $conn->close();
    }

    function gillaInlagg(){

        include('dbh.inc.php');
        if(isset($_POST['anvandarId']) && isset($_POST['inlaggsId'])){
            $anvandarId = mysqli_real_escape_string($conn, $_POST['anvandarId']); //Användar-ID
            $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']); //Blogginlägg-ID
        }
        $redan_gillat = mysqli_query($conn, "SELECT anvandarId, inlaggId FROM gillningar WHERE anvandarId='$anvandarId' AND inlaggId='$inlaggsId'");

        if($redan_gillat->num_rows == 0){
            $like = "INSERT INTO gillningar(anvandarId, inlaggId) VALUES ('$anvandarId', '{$inlaggsId}')";
            if(mysqli_query($conn, $like)){

                $gillaInlaggJson = array(
                    'code'=> '201',
                    'status'=> 'Created',
                    'msg' => 'Like applied',
                    'like' => array(
                        'userid'=>$anvandarId,
                        'postid'=>$inlaggsId
                    )
                );
                
                echo json_encode($gillaInlaggJson);

            } else{
                $gillaInlaggJsonError = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'like' => array(
                        'userid'=>$anvandarId,
                        'postid'=>$inlaggsId
                    )
                );
                
                echo json_encode($gillaInlaggJsonError);
            }
        } else {
            $dislike = "DELETE FROM gillningar WHERE anvandarId='$anvandarId' AND inlaggId='$inlaggsId'";
            if(mysqli_query($conn, $dislike)){

                $ogillaInlaggJson = array(
                    'code'=> '201',
                    'status'=> 'Created',
                    'msg' => 'Dislike applied',
                    'like' => array(
                        'userid'=>$anvandarId,
                        'postid'=>$inlaggsId
                    )
                );
                
                echo json_encode($ogillaInlaggJson);

            } else{
                $ogillaInlaggJsonError = array(
                    'code'=> '201',
                    'status'=> 'Created',
                    'msg' => 'Dislike applied',
                    'like' => array(
                        'userid'=>$anvandarId,
                        'postid'=>$inlaggsId
                    )
                );
                
                echo json_encode($ogillaInlaggJsonError);
            }
        }

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
    function flaggaKommentar(){
        include('dbh.inc.php');
        if(isset($_POST['kommentarsid']) && isset($_POST['anvandarID'])){
            $komid = $_POST['kommentarsid']; 
            $anvandarId = $_POST['anvandarID']; 
        }
        $redan_flaggat = mysqli_query($conn, "SELECT anvandarId FROM flaggadkommentar WHERE anvandarId='$anvandarId' AND kommentarId='$komid'");


        if($redan_flaggat->num_rows == 0){
            $flagga = "INSERT INTO flaggadkommentar(anvandarId, kommentarId) VALUES ('{$anvandarId}', '{$komid}')";
            $conn->query($flagga);
        }
        
        /*
        om denna del inte är bortkommenterad tas flaggan bort om man anropar funktionen igen med samma värden.
        else{
            $avflagga = "DELETE FROM flaggadkommentar WHERE anvandarId='$anvandarId' AND kommentarId='$komid'";
            $conn->query($avflagga);
        }
        */
        
        
        header("Location: ../index.php");
        $conn->close();

    }
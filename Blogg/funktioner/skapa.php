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
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
    
    
 

    function skapaBlogg($conn){

       //- include("../../Databas/dbh.inc.php");
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
            $skapaInlaggJson = array(
                'code'=> '201',
                'status'=> 'Created',
                'msg' => 'Post created',
                'post' => array(
                    'bloggid'=>$bloggID,
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
                    'bloggid'=>$bloggID,
                    'title'=>$title,
                    'content'=>$innehall,
                    'date'=>$date
                )
            );
            
            echo json_encode($skapaInlaggJsonError);
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


    function sokFalt($conn){
        //-include("../../Databas/dbh.inc.php");
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
                    'dislike' => array(
                        'userid'=>$anvandarId,
                        'postid'=>$inlaggsId
                    )
                );
                
                echo json_encode($ogillaInlaggJson);

            } else{
                $ogillaInlaggJsonError = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'dislike' => array(
                        'userid'=>$anvandarId,
                        'postid'=>$inlaggsId
                    )
                );
                
                echo json_encode($ogillaInlaggJsonError);
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

            $flaggaBloggJson = array(
                'code'=> '201',
                'status'=> 'Created',
                'msg' => 'Dislike applied',
                'flag' => array(
                    'userid'=>$anvandarId,
                    'postid'=>$inlaggsId
                )
            );
            
            echo json_encode($flaggaBloggJson);
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

            $flaggaKommentarJson = array(
                'code'=> '202',
                'status'=> 'Accepted',
                'msg' => 'Comment flagged',
                'flag' => array(
                    'commentid'=>$komid,
                    'userid'=>$anvandarId
                )
            );
            
            echo json_encode($flaggaKommentarJson);
        } else {
            $flaggaKommentarJsonError = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Could not executed',
                'flag' => array(
                    'commentid'=>$komid,
                    'userid'=>$anvandarId
                )
            );
            
            echo json_encode($flaggaKommentarJsonError);
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
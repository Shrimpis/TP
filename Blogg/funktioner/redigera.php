<?php

// Funktion för redigera //

session_start();
include("../../Databas/dbh.inc.php");

        switch ($_POST['funktion']) {
            case 'redigeraBlogg':
                redigeraBlogg($conn);
                break;
            case 'redigeraKommentar':
                redigeraKommentar($conn);
                break;
            case 'redigeraInlagg':
                redigeraInlagg($conn);
                break;
            case 'privatiseraBlogg':
                privatiseraBlogg($conn);
                break;
            case 'censureraKommentar':
                censureraKommentar($conn);
                break;
            default:
                hantering('400','Din förfrågan måste vara utanför våra parametrar. Kolla dokumentationen.',);
        } 

function redigeraBlogg($conn){
    //- include("../../Databas/dbh.inc.php");
    if(isset($_POST['bloggId']) && isset($_POST['Titel'])){
        $Bid = $_POST['bloggId'];
        $title = $_POST['Titel'];
    }
    $uppdateraBlogg = "UPDATE tjanst SET titel = '{$title}' WHERE id = $Bid ";
    
    if(mysqli_query($conn, $uppdateraBlogg)){

        hantering('202','Bloggen är ändrad.',);

    } else {

        hantering('400','Kunde inte uppdatera bloggen',);
        
    }
    $conn->close();
}
function privatiseraBlogg($conn){
    //-include("../../Databas/dbh.inc.php");
    if(isset($_POST['bloggId'])&&isset($_POST['privat'])){
        $bloggId = $_POST['bloggId'];
        $privat = $_POST['privat'];   
    }

    $result = $conn->query("SELECT * FROM blogg where id= $bloggId ");
        $row = $result->fetch_assoc();
        $tjanstId = $row['tjanstId'];
        $uppdateraTjanst = "UPDATE tjanst SET privat = '{$privat}' WHERE id = $tjanstId ";
    
    
    
    
    if(mysqli_query($conn, $uppdateraTjanst)){

        $privatiseraTjanstJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'tjanst har redigerats',
            'tjanst' => array(
                'bloggId'=>$bloggId,
            )
        );
        
        echo json_encode($privatiseraTjanstJson);
    } else {
        $privatiseraTjanstJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'tjanst' => array(
                'bloggId'=>$bloggId,
            )
        );
        
        echo json_encode($privatiseraTjanstJsonError);
    }
    $conn->close();
}

function redigeraKommentar($conn){
    //-include("../../Databas/dbh.inc.php");
    if(isset($_POST['kommentarId']) && isset($_POST['text'])){
        $Kid = $_POST['kommentarId'];
        $text = $_POST['text'];
    }

    $uppdateraKommentar = "UPDATE kommentar SET innehall = '{$text}' WHERE id = $Kid ";

    if(mysqli_query($conn, $uppdateraKommentar)){

        $redigeraKommentarJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Comment uppdated',
            'comment' => array(
                'commentID'=>$Kid
            )
        );
        
        echo json_encode($redigeraKommentarJson);

    } else {
        $redigeraKommentarJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'comment' => array(
                'commentID'=>$Kid
            )
        );
        
        echo json_encode($redigeraKommentarJsonError);
    }
    $conn->close();
}

function redigeraInlagg($conn){
    //-include("../../Databas/dbh.inc.php");

    $inlaggsId = $_POST['inlaggsId'];
    $title = $_POST['Titel'];
    $innehall = $_POST['innehall'];
    $uppdateraInlagg = "UPDATE blogginlagg SET titel = '{$title}', innehall = '{$innehall}' WHERE id = $inlaggsId ";
    
    if(mysqli_query($conn, $uppdateraInlagg )){
        $redigeraInlaggJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Post uppdated',
            'post' => array(
                'postID'=>$inlaggsId
            )
        );
        
        echo json_encode($redigeraInlaggJson);

    } else {
        $redigeraInlaggJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'post' => array(
                'postID'=>$inlaggsId
            )
        );
        
        echo json_encode($redigeraInlaggJsonError);
    }
    $conn->close();
}

function censureraKommentar($conn){
    //-include("../../Databas/dbh.inc.php");
    if(isset($_POST['id']) ){
        $id = $_POST['id'];
    }
    $kommentar = $conn->query('select * from kommentar where id ='.$id);

        $row = $kommentar->fetch_assoc();
        $censurerad=$row["censurerad"];
        while($censurerad < 2){
           
            if($censurerad==0){
                $sql= "UPDATE kommentar SET censurerad = '1' WHERE id = $id ";
                $conn->query($sql);

                $censureraKommentarJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'Comment censored',
                    'comment' => array(
                        'commentID'=>$id
                    )
                );
                
                echo json_encode($censureraKommentarJson);

                break;
               
            }
            else if($censurerad==1){
                $sql= "UPDATE kommentar SET censurerad = '0' WHERE id = $id ";
                $conn->query($sql);

                $avCensureraKommentarJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'Comment is now public',
                    'comment' => array(
                        'commentID'=>$id 
                    )
                );
                
                echo json_encode($avCensureraKommentarJson);

               break;
            }
            else{
                $censureraKommentarErrorJson = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'comment' => array(
                        'commentID'=>$id 
                    )
                );
                
                echo json_encode($censureraKommentarErrorJson);

               break;
            }
        }
        
    
    $conn->close();
}

?>
<?php

// Funktion för redigera //

session_start();
include("dbh.inc.php");

        switch ($_POST['funktion']) {
            case 'redigeraBlogg':
                redigeraBlogg();
                break;
            case 'redigeraKommentar':
                redigeraKommentar();
                break;
            case 'redigeraInlagg':
                redigeraInlagg();
                break;
            case 'privatiseraBlogg':
                privatiseraBlogg();
                break;
            case 'censureraKommentar':
                censureraKommentar();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();

function redigeraBlogg(){
    include("dbh.inc.php");
    if(isset($_POST['bloggId']) && isset($_POST['Titel'])){
        $Bid = $_POST['bloggId'];
        $title = $_POST['Titel'];
    }
    $uppdateraBlogg = "UPDATE tjanst SET titel = '{$title}' WHERE id = $Bid ";
    
    if(mysqli_query($conn, $uppdateraBlogg)){

        $redigeraBloggJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Blogg edited',
            'blogg' => array(
                'bloggid'=>$bloggId,
                'title'=>$title
            )
        );
        
        echo json_encode($redigeraBloggJson);

    } else {
        $redigeraBloggJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'blogg' => array(
                'bloggid'=>$bloggId,
                'title'=>$title
            )
        );
        
        echo json_encode($redigeraBloggJsonError);
    }
    $conn->close();
}
function privatiseraBlogg(){
    include("dbh.inc.php");
    if(isset($_POST['bloggid'])&&isset($_POST['privat'])){
        $Bid = $_POST['bloggid'];
        $privat = $_POST['privat'];   
    }
    
    $uppdateraBlogg = "UPDATE tjanst SET privat = '{$privat}' WHERE id = $Bid ";
    
    if(mysqli_query($conn, $uppdateraBlogg)){

        $privatiseraBloggJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Blogg is now private',
            'blogg' => array(
                'bloggid'=>$Bid,
            )
        );
        
        echo json_encode($privatiseraBloggJson);
    } else {
        $privatiseraBloggJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'blogg' => array(
                'bloggid'=>$Bid,
            )
        );
        
        echo json_encode($privatiseraBloggJsonError);
    }
    $conn->close();
}

function redigeraKommentar(){
    include("dbh.inc.php");
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

function redigeraInlagg(){
    include("dbh.inc.php");

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

function censureraKommentar(){
    include("dbh.inc.php");
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
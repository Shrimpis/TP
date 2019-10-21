<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'tabortBlogg':
                tabortBlogg();
                break;
            case 'tabortInlagg':
                tabortInlagg();
                break;
            case 'tabortKommentar':
                tabortKommentar();
                break;
            case 'tabortTextruta':
                tabortTextruta();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();


function tabortBlogg(){
    include('dbh.inc.php');
    $bloggId = $_POST['bloggId'];

    $delTjanst = "DELETE FROM tjanst WHERE id='{$bloggId}'";
    $delBlogg = "DELETE FROM blogg WHERE tjanstId='{$bloggId}'";
    $delInlagg = "DELETE FROM blogginlagg WHERE bloggId='{$bloggId}'";

    $IIDarray = ($conn->query("SELECT id FROM blogginlagg WHERE bloggId ='{$bloggId}'"));
    
    while($row = $IIDarray->fetch_assoc()){
        $inlaggsId= $row['id'];
    
        $delKommentar="DELETE FROM kommentar WHERE inlaggId=$inlaggsId";
        $conn->query($delKommentar);
        
    }
    if(mysqli_query($conn, $delBlogg)&&mysqli_query($conn, $delInlagg)&&mysqli_query($conn, $delTjanst)){
        $tabortBloggJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Blogg delted',
            'blogg' => array(
                'bloggid'=>$bloggId
            )
        );
        
        echo json_encode($tabortBloggJson);
    } else {
        $tabortBloggJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'blogg' => array(
                'bloggid'=>$bloggId
            )
        );
        
        echo json_encode($tabortBloggJsonError);
    }

    $conn->close();

}

function tabortInlagg(){
    include('dbh.inc.php');
    $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']);
    $delInlagg = "DELETE FROM blogginlagg WHERE id='{$inlaggsId}'";
    $delKommentar = "DELETE FROM kommentar WHERE inlaggId=$inlaggsId";

    if(mysqli_query($conn, $delInlagg)&&mysqli_query($conn, $delKommentar)){
        $tabortInlaggJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Post deleted',
            'blogg' => array(
                'bloggid'=>$bloggId
            )
        );
        
        echo json_encode($tabortInlaggJson);
    } else {
        $tabortInlaggJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'blogg' => array(
                'bloggid'=>$bloggId
            )
        );
        
        echo json_encode($tabortInlaggJsonError);
    }

    $conn->close();

}

function tabortKommentar(){
    
    include('dbh.inc.php');
    $kommentarId = mysqli_real_escape_string($conn, $_REQUEST['kommentarId']);
    $KIDarray[0] = $kommentarId;
    $temparray = array();
    
    $KIDarray = loop($kommentarId,$conn,$KIDarray,$temparray);
    
    $deleteID = implode(',',$KIDarray);
    
    $sql = "DELETE FROM kommentar WHERE id in ($deleteID)";
    
    if(mysqli_query($conn, $sql)){
        $tabortKommentarJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'Comment deleted',
            'comment' => array(
                'commentid'=>$kommentarId
            )
        );
        
        echo json_encode($tabortKommentarJson);
    } else {
        $tabortKommentarJsonError = array(
            'code'=> '400',
            'status'=> 'Bad',
            'msg' => 'Could not execute',
            'comment' => array(
                'commentid'=>$kommentarId
            )
        );
        
        echo json_encode($tabortKommentarJsonError);
    }
    


}
// tillhör tabortkommentar
function loop($kommentarId,$conn,$KIDarray,$temparray){
    if(count($temparray) > 0 ){
        for($i=0;$i<count($temparray);$i++){
        array_push($KIDarray,$temparray[$i]);
        }
        
    }

$looparray = ($conn->query("SELECT id from kommentar where hierarkiId ='{$kommentarId}'"));

$temparray = array();
if(mysqli_num_rows($looparray) > 0)
    while($row=$looparray->fetch_assoc()){
    
    
        array_push($temparray,$row['id']);
    
    
    
    
    
    }

    if(count($temparray)>0){
        
        return loop($temparray[0],$conn,$KIDarray,$temparray);
    }




    //cred to Brandon 4 code help big thx



    
    return $KIDarray;  
}

?>
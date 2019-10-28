<?php

// Funktioner för att ta bort

session_start();

include("../../Databas/dbh.inc.php");
        switch ($_GET['funktion']) {

            case 'tabortBlogg':
                tabortBlogg($conn);
                break;
            case 'tabortInlagg':
                tabortInlagg($conn);
                break;
            case 'tabortKommentar':
                tabortKommentar($conn);
                break;
            case 'tabortTextruta':
                tabortTextruta($conn);
                break;
            default:
                hantering('400','Din förfrågan är utanför våra parametrar, kolla dokumentationen',);
        } 


function tabortBlogg($conn){
    //-include("../../Databas/dbh.inc.php");
    if(isset($_GET['bloggId'])){
    $bloggId = $_GET['bloggId'];

    $taBortTjanst = "DELETE FROM tjanst WHERE id='{$bloggId}'";
    $taBortFlaggningBlogg = "DELETE FROM flaggadblogg WHERE bloggId = '{$bloggId}'";
    $taBortBlogg = "DELETE FROM blogg WHERE tjanstId='{$bloggId}'";
    $taBortInlagg = "DELETE FROM blogginlagg WHERE bloggId='{$bloggId}'";
    $inlaggsId = ($conn->query("SELECT id FROM blogginlagg WHERE bloggId = $bloggId"));
    $kommentarId = ($conn->query("SELECT id FROM kommentar WHERE inlaggId = $inlaggsId"));
    $taBortFlaggningKommentar = "DELETE FROM flaggadkommentar WHERE kommentarId = '{$kommentarId}'";
    $taBortKommentar = "DELETE FROM kommentar WHERE inlaggId = $inlaggsId";
    $taBortLike = "DELETE FROM gillningar WHERE inlaggId = $inlaggsId";

    

    if(mysqli_query($conn, $taBortFlaggningBlogg)){

        hantering('200','Flaggning på bloggen har tagits bort',);

    }else{

        hantering('400','Flaggning på bloggen kunde inte tas bort',);

    }
    while($row = $kommentarId->fetch_assoc()){
        $kommentarId = $row['id'];

        if(mysqli_query($conn, $taBortFlaggningKommentar)){

            hantering('200','Flaggningen på kommentaren har tagits bort',);

        }else{

            hantering('400','Flaggningen på kommentaren kunde inte tas bort',);

        }

    }
    while($row = $inlaggsId->fetch_assoc()){
        $inlaggsId= $row['id'];
    
        if(mysqli_query($conn, $taBortKommentar)){

            hantering('200','Kommentaren togs bort',);

        }else{

            hantering('400','Kommentaren kunde inte tas bort',);
            return;

        }
        if(mysqli_query($conn, $taBortLike)){

            hantering('200','Inlägget gillas inte längre',);

        }else{

            hantering('400','Kunde inte ändra gilla statusen på inlägget',);
            return;

        }
        
    }
    if(mysqli_query($conn, $taBortInlagg)){

        hantering('200','Blogginlägget har tagits bort',);

    }else{

        hantering('400','Blogginlägget kunde inte tas bort',);
        
    }
    if(mysqli_query($conn, $taBortBlogg)){

        hantering('200','Bloggen har tagits bort',);

    } else {

        hantering('400','Bloggen kunde inte tas bort',);

    }
    if(mysqli_query($conn, $taBortTjanst)){

        hantering('200','Tjänsten har tagits bort',);

    }else{

        hantering('400','Tjänsten kunde inte tas bort',);

    }

}

    $conn->close();

}

function tabortInlagg($conn){
    //-include("../../Databas/dbh.inc.php");
    $inlaggsId = mysqli_real_escape_string($conn, $_GET['inlaggsId']);
    $delInlagg = "DELETE FROM blogginlagg WHERE id='{$inlaggsId}'";
    $delKommentar = "DELETE FROM kommentar WHERE inlaggId=$inlaggsId";
    $delLike="DELETE FROM gillningar WHERE inlaggId=$inlaggsId";

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
    if(mysqli_query($conn, $delLike)){



    }else{



    }

    $conn->close();

}

function tabortKommentar($conn){
    
    //-include("../../Databas/dbh.inc.php");
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
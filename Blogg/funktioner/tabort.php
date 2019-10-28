<?php

// Funktioner för att ta bort

session_start();

include("../../Databas/dbh.inc.php");
        switch ($_POST['funktion']) {

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
    if(isset($_POST['bloggId'])){
    $bloggId = $_POST['bloggId'];

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
    $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']);
    $taBortInlagg = "DELETE FROM blogginlagg WHERE id='{$inlaggsId}'";
    $taBortKommentar = "DELETE FROM kommentar WHERE inlaggId=$inlaggsId";
    $taBortLike="DELETE FROM gillningar WHERE inlaggId=$inlaggsId";

    if(mysqli_query($conn, $taBortKommentar)){

        

    } else {



    }
    if(mysqli_query($conn, $taBortLike)){



    }else{



    }
    if(mysqli_query($conn, $taBortInlagg)){



    }else{



    }

    $conn->close();

}

function tabortKommentar($conn){
    
    //-include("../../Databas/dbh.inc.php");
    $kommentarId = mysqli_real_escape_string($conn, $_POST['kommentarId']);
    $kommentarIDArray[0] = $kommentarId;
    $temparray = array();
    
    $kommentarIDArray = loop($kommentarId,$conn,$kommentarIDArray,$temparray);
    
    $taBortID = implode(',',$kommentarIDArray);
    
    $taBortKommentar = "DELETE FROM kommentar WHERE id in ($taBortID)";
    
    if(mysqli_query($conn, $taBortKommentar)){

        hantering('200','Kommentaren har tagits bort',);

    } else {

        hantering('400','Kommentaren kunde inte tas bort',);

    }
    


}
// tillhör tabortkommentar
function loop($kommentarId,$conn,$kommentarIDArray,$temparray){
    if(count($temparray) > 0 ){
        for($i=0;$i<count($temparray);$i++){
        array_push($kommentarIDArray,$temparray[$i]);
        }
        
    }

$looparray = ($conn->query("SELECT id from kommentar where hierarkiId ='{$kommentarId}'"));

$temparray = array();
if(mysqli_num_rows($looparray) > 0)
    while($row=$looparray->fetch_assoc()){
    
        array_push($temparray,$row['id']);
    
    }

    if(count($temparray)>0){
        
        return loop($temparray[0],$conn,$kommentarIDArray,$temparray);
    }

    return $kommentarIDArray;  
}

?>
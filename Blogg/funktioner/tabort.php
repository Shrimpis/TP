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
                hantering('404','Din förfrågan är utanför våra parametrar, kolla dokumentationen',);
        } 


function tabortBlogg($conn){
    //-include("../../Databas/dbh.inc.php");
    if(isset($_POST['bloggId'])){
    $bloggId = $_POST['bloggId'];

    $tjanstId = ($conn->query("SELECT tjanstId FROM blogg WHERE id = $bloggId"));
    $taBortBlogg = "DELETE FROM tjanst WHERE id='{$tjanstId}'";

    if(mysqli_query($conn, $taBortBlogg)){

        hantering('204','Bloggen har tagits bort',);

    }else{

        hantering('400','Bloggen kunde inte tas bort',);

    }

}

    $conn->close();

}

function tabortInlagg($conn){
  
    $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']);
    $taBortInlagg = "DELETE FROM blogginlagg WHERE id='{$inlaggsId}'";

    if(mysqli_query($conn, $taBortInlagg)){

        hantering('204','Bloggen har tagits bort',);

    }else{

        hantering('400','Bloggen har tagits bort',);

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

        hantering('204','Kommentaren har tagits bort',);

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
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
        echo "INFO: Blogg borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $delBlogg,$delInlagg. " . mysqli_error($conn);
    }

    $conn->close();

}

function tabortInlagg(){
    include('dbh.inc.php');
    $inlaggsId = mysqli_real_escape_string($conn, $_POST['inlaggsId']);
    $delInlagg = "DELETE FROM blogginlagg WHERE id='{$inlaggsId}'";
    $delKommentar = "DELETE FROM kommentar WHERE inlaggId=$inlaggsId";

    if(mysqli_query($conn, $delInlagg)&&mysqli_query($conn, $delRuta)&&mysqli_query($conn, $delText)&&mysqli_query($conn, $delKommentar)){
        echo "INFO: Blogginlagg borttaget";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $delInlagg,$delRuta,$delText,$delKommentar. " . mysqli_error($conn);
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
        echo "INFO: kommentar borttaget";
    } else {
        echo "ERROR: Could not execute $delKommentar. " . mysqli_error($conn);
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
<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
if (isset($_SESSION["licens"]) && isset($_SESSION["UID"])) {

    $sql = "SELECT *FROM LICENS WHERE ID =" . $_SESSION["UID"];
    $result = $conn->query($sql);
    $result = mysqli_fetch_assoc($result);

    if ($_SESSION["licens"] == $result["licens_key"]) {
        switch ($_GET['funktion']) {

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
    } else {
        echo "Felaktig/gammal licens. kontakta en adminstratör";
    }
} else {
    echo "Ingen licens. Kontakta adminstratör";
}
$conn->close();


function tabortBlogg(){
    
    $BID = mysqli_real_escape_string($conn, $_POST['BID']);
    $delBlogg = "DELETE FROM blogg WHERE id='{$BID}'";
    $delInlagg = "DELETE FROM blogginlagg WHERE bloggId='{$BID}'";

    $IIDarray = ($conn->query("SELECT inlaggId FROM blogginlagg WHERE bloggId ='{$BID}'"));
    
    while($row = $IIDarray->fetch_assoc()){
        $IID= $row['id'];
    
        $delKommentar="DELETE FROM kommentar WHERE inlaggId=$IID";
        $conn->query($delKommentar);
        
    }
    if(mysqli_query($conn, $delBlogg)&&mysqli_query($conn, $delInlagg)){
        echo "INFO: Blogg borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $delBlogg,$delInlagg. " . mysqli_error($conn);
    }

    $conn->close();

}

function tabortInlagg(){
    include('dbh.inc.php');
    $IID = mysqli_real_escape_string($conn, $_POST['IID']);
    $delInlagg = "DELETE FROM blogginlagg WHERE id='{$IID}'";
    $delKommentar = "DELETE FROM kommentar WHERE inlaggId=$IID";

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
    $KID = mysqli_real_escape_string($conn, $_REQUEST['KID']);
    $KIDarray[0] = $KID;
    $temparray = array();
    
    $KIDarray = loop($KID,$conn,$KIDarray,$temparray);
    
    $deleteID = implode(',',$KIDarray);
    
    $sql = "DELETE FROM kommentar WHERE id in ($deleteID)";
    
    if(mysqli_query($conn, $sql)){
        echo "INFO: kommentar borttaget";
    } else {
        echo "ERROR: Could not execute $delKommentar. " . mysqli_error($conn);
    }
    


}
// tillhör tabortkommentar
function loop($KID,$conn,$KIDarray,$temparray){
    if(count($temparray) > 0 ){
        for($i=0;$i<count($temparray);$i++){
        array_push($KIDarray,$temparray[$i]);
        }
        
    }

$looparray = ($conn->query("SELECT KID from kommentar where hierarkiId ='{$KID}'"));

$temparray = array();
if(mysqli_num_rows($looparray) > 0)
    while($row=$looparray->fetch_assoc()){
    
    
        array_push($temparray,$row['KID']);
    
    
    
    
    
    }

    if(count($temparray)>0){
        
        return loop($temparray[0],$conn,$KIDarray,$temparray);
    }




    //cred to Brandon 4 code help big thx



    
    return $KIDarray;  
}

?>
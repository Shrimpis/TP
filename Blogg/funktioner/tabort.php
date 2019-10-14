<?php

// Funktioner för att ta bort

//Anropas via följande url:
// http://localhost/tp/funktioner/tabort.php?key=SvvVuxb9gzQYtkjNYdEVvxnP&f=FUNKTIONSNAMN&BID=5

session_start();
include("dbh.inc.php");
if (isset($_SESSION["licens"]) && isset($_SESSION["anvandare"])) {

    $sql = "SELECT *FROM LICENS WHERE ID =" . $_SESSION["anvandare"];
    $result = $conn->query($sql);
    $result = mysqli_fetch_assoc($result);

    if ($_SESSION["licens"] == $result["licens"]) {
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
    } else {
        echo "Felaktig/gammal licens. kontakta en adminstratör";
    }
} else {
    echo "Ingen licens. Kontakta adminstratör";
}
$conn->close();


function tabortBlogg(){
    
    $BID = mysqli_real_escape_string($conn, $_POST['BID']);
    $delBlogg = "DELETE FROM blogg WHERE BID='{$BID}'";
    $delInlagg = "DELETE FROM blogginlagg WHERE BID='{$BID}'";

    $IIDarray = ($conn->query("SELECT IID FROM blogginlagg WHERE BID ='{$BID}'"));
    
    while($row = $IIDarray->fetch_assoc()){
        $IID= $row['IID'];
        
        $delText="DELETE FROM textruta WHERE IID=$IID";
        $delRuta="DELETE FROM rutor WHERE IID=$IID";
        $delKommentar="DELETE FROM kommentar WHERE IID=$IID";
        
        $conn->query($delText);
        $conn->query($delRuta);
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
    $delInlagg = "DELETE FROM blogginlagg WHERE IID='{$IID}'";
    $delRuta = "DELETE FROM rutor WHERE IID='{$IID}'";
    $delText = "DELETE FROM textruta WHERE IID='{$IID}'";
    $delKommentar = "DELETE FROM kommentar WHERE IID=$IID";

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
    
    var_dump($KIDarray);
    echo "<br>";
    
    $deleteID = implode(',',$KIDarray);
    
    $sql = "DELETE FROM kommentar WHERE KID in ($deleteID)";
    
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

$looparray = ($conn->query("SELECT KID from kommentar where HierarchyID ='{$KID}'"));

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

function tabortTextruta(){
    include('dbh.inc.php');
    $RID = mysqli_real_escape_string($conn, $_POST['RID']);
    $delRuta = "DELETE FROM rutor WHERE RID='{$RID}'";

    if(mysqli_query($conn, $delRuta)){
        echo "INFO: Ruta borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $delRuta. " . mysqli_error($conn);
    }

    $conn->close();

}

?>
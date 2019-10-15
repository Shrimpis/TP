<?php

// Ta bort funktioner //
//Anropas via följande url:
// http://localhost/tp/funktioner/tabort.php?key=SvvVuxb9gzQYtkjNYdEVvxnP&f=FUNKTIONSNAMN&BID=5

$auth = "SvvVuxb9gzQYtkjNYdEVvxnP"; //Autorisationsnyckel/Licsensnyckeln

session_start();

if (isset($_SESSION["licens"]) && isset($_SESSION["UID"])) {

    $sql = "SELECT *FROM LICENS WHERE ID =" . $_SESSION["UID"];
    $result = $db->query($sql);
    $result = mysqli_fetch_assoc($result);

    if ($_SESSION["licens"] == $result["licens"]) {
        switch ($_GET['f']) {
            case 'tabortBlogg':
                tabortBlogg();
                break;
            case 'tabortInlagg';
                tabortInlagg();
                break;
            case 'tabortKommentar';
                tabortKommentar();
                break;
            case 'tabortTextruta';
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



function tabortBlogg(){
    include('dbh.inc.php');
    $BID = mysqli_real_escape_string($conn, $_POST['BID']);
    $sql = "DELETE FROM blogg WHERE BID='{$BID}'";
    $sql2 = "DELETE FROM blogginlagg WHERE BID='{$BID}'";

    $IIDarray = ($conn->query("SELECT IID from blogginlagg where BID ='{$BID}'"));
    
    while($row = $IIDarray->fetch_assoc()){
        $IID= $row['IID'];
        
        $sql3="DELETE FROM textruta WHERE IID=$IID";
        $sql4="DELETE FROM rutor WHERE IID=$IID";
        $sql5="DELETE FROM kommentar WHERE IID=$IID";
        
        $conn->query($sql3);
        $conn->query($sql4);
        $conn->query($sql5);
        
    }
    if(mysqli_query($conn, $sql)&&mysqli_query($conn, $sql2)){
        echo "INFO: Blogg borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql,$sql2. " . mysqli_error($conn);
    }

    $conn->close();

}

function tabortInlagg(){
    include('dbh.inc.php');
    $IID = mysqli_real_escape_string($conn, $_POST['IID']);
    $sql = "DELETE FROM blogginlagg WHERE IID='{$IID}'";
    $sql2 = "DELETE FROM rutor WHERE IID='{$IID}'";
    $sql3 = "DELETE FROM textruta WHERE IID='{$IID}'";
    $sql5="DELETE FROM kommentar WHERE IID=$IID";

    if(mysqli_query($conn, $sql)&&mysqli_query($conn, $sql2)&&mysqli_query($conn, $sql3)&&mysqli_query($conn, $sql5)){
        echo "INFO: Blogginlagg borttaget";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql,$sql2,$sql3. " . mysqli_error($conn);
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
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
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




    //cred to BrandonBoi 4 code help big thx



    
    return $KIDarray;  
}

function tabortTextruta(){
    include('dbh.inc.php');
    $RID = mysqli_real_escape_string($conn, $_POST['RID']);
    $sql = "DELETE FROM rutor WHERE RID='{$RID}'";

    if(mysqli_query($conn, $sql)){
        echo "INFO: Ruta borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }

    $conn->close();

}

?>
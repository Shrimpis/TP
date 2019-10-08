<?php

// Ta bort funktioner //
$auth = "SvvVuxb9gzQYtkjNYdEVvxnP";

if($_GET['key'] == $auth){
    switch($_GET['f']) {
        case 'tabortBlogg': // http://localhost/tp/funktioner/tabort.php?key=SvvVuxb9gzQYtkjNYdEVvxnP&f=tabortBlogg&BID=5
            tabortBlogg();
            break;
        case 'tabortInlagg'; // http://localhost/tp/funktioner/tabort.php?key=SvvVuxb9gzQYtkjNYdEVvxnP&f=tabortInlagg&IID=5
            tabortInlagg();
            break;
    $KID = mysqli_real_escape_string($conn, $_REQUEST['KID']);
        case 'tabortKommentar'; // http://localhost/tp/funktioner/tabort.php?key=SvvVuxb9gzQYtkjNYdEVvxnP&f=tabortKommentar&KID=5
            tabortKommentar();
            break;
        case 'tabortTextruta'; // http://localhost/tp/funktioner/tabort.php?key=SvvVuxb9gzQYtkjNYdEVvxnP&f=tabortTextruta&RID=5
            tabortTextruta();
            break;
        default:
            echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
} else {
    echo "ERROR: Ogiltig autorisationsnyckel.";
}

function tabortBlogg(){
    include('dbh.inc.php');
    $BID = mysqli_real_escape_string($conn, $_REQUEST['BID']);
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
}

function tabortInlagg(){
    include('dbh.inc.php');
    $IID = mysqli_real_escape_string($conn, $_REQUEST['IID']);
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
}

function tabortKommentar(){
    include('dbh.inc.php');
    $KID = mysqli_real_escape_string($conn, $_REQUEST['KID']);
    $sql = "DELETE FROM kommentar WHERE KID='{$KID}'";

    if(mysqli_query($conn, $sql)){
        echo "INFO: kommentar borttaget";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }

}

function tabortTextruta(){
    include('dbh.inc.php');
    $RID = mysqli_real_escape_string($conn, $_REQUEST['RID']);
    $sql = "DELETE FROM rutor WHERE RID='{$RID}'";

    if(mysqli_query($conn, $sql)){
        echo "INFO: Ruta borttagen";
        header('Refresh: 2; URL = ../index.php');
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
}

?>
<?php 

session_start();
include("dbh.inc.php");




    
        switch ($_GET['funktion']) {
            case 'skapaKonto':
                skapaKonto();
                break;
            case 'skapaAKonto':
                skapaAKonto();
                break;

            default:    
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
                break;
        }
    
 
$conn->close();

function skapaKonto(){
    include("dbh.inc.php");
    $uname_tagen=false;
    if(isset($_POST['anamn'])){
        $username= $_POST['anamn'];
    }
    $password = slumplosen(10);
    
    $sqlcheck = ($conn->query("SELECT anamn from anvandare"));
    while($row=$sqlcheck->fetch_assoc()){
        if($username==$row['anamn']){
            $uname_tagen=true;
        }
    }
    if($uname_tagen==false){
        $sql= "INSERT INTO anvandare(anamn, losenord) VALUES ('$username','$password')";
        var_dump($sql);
        $conn->query($sql);
        header('Refresh: 5; URL = ../index.php');
    }
    else{
        echo "användarnamnet är taget faktiskt, ifall du inte visste det (men nu vet du)!";
        header('Refresh: 5; URL = ../index.php');
    }
    $conn->close();
    
}
function slumplosen($len) {
    $karaktr = '?$£@!#%&0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $karaktrlen = strlen($karaktr);
    $slumpstr = '';
    for ($i = 0; $i < $len; $i++) {
        $slumpstr .= $karaktr[rand(0, $karaktrlen - 1)];
    }
    return $slumpstr;
}
function skapaAKonto(){
    include("dbh.inc.php");
    $uname_tagen=false;
    if(isset($_GET['anamn'])&&isset($_GET['rollid'])){
        $username = $_GET['anamn'];
        $rollid = $_GET['rollid'];
    }
    $password = slumplosen(10);
    
    $sqlcheck = ($conn->query("SELECT anamn from anvandare"));
    while($row=$sqlcheck->fetch_assoc()){
        if($username==$row['anamn']){
            $uname_tagen=true;
        }
    }
    if($uname_tagen==false){
        $sql= "INSERT INTO anvandare(anamn, losenord) VALUES ('$username','$password')";
        var_dump($sql);
        $conn->query($sql);
        header('Refresh: 5; URL = ../kontoformsadmin.php');
    }
    else{
        echo "användarnamnet är taget faktiskt, ifall du inte visste det (men nu vet du)!";
        header('Refresh: 5; URL = ../kontoformsadmin.php');
    }
    $conn->close();
    
}



?>
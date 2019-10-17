<?php 

session_start();
include("dbh.inc.php");
        switch ($_POST['funktion']) {
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
    if(isset($_POST['anamn'])&&isset($_POST['rollid'])){
        $username = $_POST['anamn'];
        $rollid = $_POST['rollid'];
    }
    $password = slumplosen(10);
    
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            echo "CRYPT_BLOWFISH is enabled!<br>";
        } else {
            echo "CRYPT_BLOWFISH is NOT enabled!";
            goto end;
        }
        
        $Blowfish_Pre = '$2a$10$';
        $Blowfish_End = '$';
        
        $Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $Chars_Len = 63;
        
        $Salt_Length = 21;
        $salt = "";
        for ($i = 0; $i < $Salt_Length; $i++) {
            $salt .= $Allowed_Chars[mt_rand(0, $Chars_Len)];
        }
        $bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
        $hashed_password = crypt($password, $bcrypt_salt);
    
    
    $sqlcheck = ($conn->query("SELECT anamn from anvandare"));
    while($row=$sqlcheck->fetch_assoc()){
        if($username==$row['anamn']){
            $uname_tagen=true;
        }
    }
    if($uname_tagen==false){
        $sql= "INSERT INTO anvandare(anamn, losenord, salt) VALUES ('$username','$hashed_password','$salt')";
        $conn->query($sql);
        
        $result = ($conn->query("SELECT id from anvandare where anamn ='{$username}'"));
        if(mysqli_num_rows($result) > 0){
            while($row=$result->fetch_assoc()){
                $USID=$row['id'];
                $sql2 = ("INSERT INTO anvandarroll(anvandarid,rollid) VALUES ($USID,$rollid)");
                $conn->query($sql2);
                header('location: ../index.php?funktion=skapaKonto?status=success&password='.$password);
            }
        }
    }
    else{
        header('location: ../index.php?funktion=skapaKonto?status=error?reason=usernameTaken');
    }
    $conn->close();
    
}

function slumplosen($len) {
    $karaktr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $karaktrlen = strlen($karaktr);
    $slumpstr = '';
    for ($i = 0; $i < $len; $i++) {
        $slumpstr .= $karaktr[rand(0, $karaktrlen - 1)];
    }
    return $slumpstr;
}

//exakt kopia av skapaKonto() men med ett annat fönster som header(refresh)
function skapaAKonto(){
    include("dbh.inc.php");
    $uname_tagen=false;
    if(isset($_POST['anamn'])&&isset($_POST['rollid'])){
        $username = $_POST['anamn'];
        $rollid = $_POST['rollid'];
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
        $result = ($conn->query("SELECT id from anvandare where anamn ='{$username}'"));
        if(mysqli_num_rows($result) > 0){
            while($row=$result->fetch_assoc()){
                $USID=$row['id'];
                $sql2 = ("INSERT INTO anvandarroll(anvandarid,rollid) VALUES ($USID,$rollid)");
                echo "<br>".$sql2;
                $conn->query($sql2);
                header('Refresh: 5; URL = ../kontoformsadmin.php');
            }
        }
        
    }
    else{
        echo "användarnamnet är taget faktiskt, ifall du inte visste det (men nu vet du)!";
        header('Refresh: 5; URL = ../kontoformsadmin.php');
    }
    $conn->close();
    
}



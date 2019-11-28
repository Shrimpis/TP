<?php

// Funktion för redigera //

session_start();
include("../../Databas/dbh.inc.php");
include("../../json/felhantering.php");
        switch ($_POST['funktion']) {
            case 'redigeraKonto':
                redigeraKonto($conn);
                break;
            case 'redigeraRoll':
                redigeraRoll($conn);
                break;
            case 'redigeraAKonto':
                redigeraAKonto($conn);
                break;
            default:
                hantering("400","Fel på URL parametrar");
                break;
        } 

function redigeraAKonto($conn){
    $uname_tagen=false;

    $uname = $_POST['anamn'];
    $losenord = $_POST['losenord'];
    $id = $_POST['id'];

    $password = $losenord;
    
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            echo "CRYPT_BLOWFISH is enabled!<br>";
        } else {
            echo "CRYPT_BLOWFISH is NOT enabled!";
        }
        
        $Blowfish_Pre = '$2a$10$';
        $Blowfish_End = '$';
        
        $Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
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
            $sql = "UPDATE anvandare SET anamn = '$uname', losenord = '$hashed_password', salt = '$salt' WHERE id = '$id'";

            $conn->query($sql);

            // Skapar mappar för bilder //

            $owner = 'theprovider';

            $blogg = '/var/www/html/TP/Bilder/Blogg/'.$username.'';
            $wiki = '/var/www/html/TP/Bilder/Wiki/'.$username.'';

            if(!mkdir($blogg, 0777, true)){
                chown($blogg, $owner);
                header('location: ../index.php?funktion=skapaKonto?status=failed?reason=blogg_folder+exists');
            }

            if(!mkdir($wiki, 0777, true)){
                chown($wiki, $owner);
                header('location: ../index.php?funktion=skapaKonto?status=failed?reason=wiki_folder+exists');
            }

            header('location: ../index.php?funktion=skapaKonto?status=success');
        }
    header('location: ../index.php?funktion=skapaKonto?status=success');
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

function redigeraKonto($conn){
    //include("../../Databas/dbh.inc.php");
    if(isset($_POST['anvandarid'])){
        $anvandarid = $_POST['anvandarid'];

    if(isset($_POST['anamn'])){
        $anamn = $_POST['anamn'];

        if(mysqli_query($conn,"UPDATE anvandare SET anamn = '{$anamn}' WHERE id = $anvandarid ")){
            hantering("202","användarnamn uppdaterat");
        }
        else{
            hantering("400","kunde ej exekvera användarnamnsbyte");
        }
    }
    if(isset($_POST['losenord'])){
        $losenord = $_POST['losenord'];
        if(mysqli_query($conn,"UPDATE anvandare SET losenord = '{$losenord}'  WHERE id = $anvandarid ")){
            hantering("202","lösenord uppdaterat");
        }
        else{
            hantering("400","kunde ej exekvera lösenordsbyte");
        }
    }
    if(isset($_POST['email'])){
        $email = $_POST['email'];

        if(mysqli_query($conn,"UPDATE anvandare SET email = '{$email}' WHERE id = $anvandarid ")){
            hantering("202","email uppdaterat");
        }
        else{
            hantering("400","kunde ej exekvera e-postbyte");
        }
    }
    }

    
    
    
    
    $conn->close();
}
function redigeraRoll($conn){
    //include("../../Databas/dbh.inc.php");
    if(isset($_POST['anvandarid']) && isset($_POST['rollid'])){
        $anvandarid = $_POST['anvandarid'];
	    $roll = $_POST['rollid'];
        
    }
    $uppdateraRoll= "UPDATE anvandarroll SET rollid = '{$roll}' where anvandarid = $anvandarid";
    
    
    
    
    if(mysqli_query($conn, $uppdateraRoll)){
        hantering("202","användarroll uppdaterat");
    } else {
        hantering("400","kunde ej exekvera rollbyte");
    }
    $conn->close();
}
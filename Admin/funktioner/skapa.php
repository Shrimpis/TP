<?php 

session_start();
include("../../Databas/dbh.inc.php");
include("../../json/felhantering.php");
        switch ($_POST['funktion']) {
            case 'skapaKonto':
                skapaKonto($conn);
                break;
            case 'skapaAKonto':
                skapaAKonto($conn);
                break;
            default:    
                hantering('400','fel på URL parametrar')
                break;
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

function skapaAKonto($conn){

    //-include("../../Databas/dbh.inc.php");
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

        $conn->query($sql);
        $result = ($conn->query("SELECT id from anvandare where anamn ='{$username}'"));
        if(mysqli_num_rows($result) > 0){
            while($row=$result->fetch_assoc()){
                $USID=$row['id'];
                $sql2 = ("INSERT INTO anvandarroll(anvandarid,rollid) VALUES ($USID,$rollid)");
                
                if(myqli_query($sql2)){
                    hantering('202','roll inlagd');
                }
                else{
                    hantering('400','kunde ej exekvera');
                }

                
                

                
            }
        }

    } 
    $conn->close();
    
}

function skapaKonto($conn){

    //-include("../../Databas/dbh.inc.php");
    $uname_tagen=false;
    if(isset($_POST['anamn'])&&isset($_POST['rollid'])&&isset($_POST['id'])){
        $username = $_POST['anamn'];
        $rollid = $_POST['rollid'];
        $id = $_POST['id'];
    }
    $password = slumplosen(10);
    
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

        $conn->query($sql);
        $result = ($conn->query("SELECT id from anvandare where anamn ='{$username}'"));
        if(mysqli_num_rows($result) > 0){
            while($row=$result->fetch_assoc()){
                $USID=$row['id'];
                $sql2 = ("INSERT INTO anvandarroll(anvandarid,rollid) VALUES ($USID,$rollid)");
                
                $conn->query($sql2);

                
                $anvandare = "SELECT anvandare.id FROM anvandare WHERE anvandare.anamn ='{$username}'";
                $result2 = $conn->query($anvandare);

                while($row2 = $result2->fetch_assoc()) {
                    $sql3 = mysqli_query($conn,"UPDATE `kundrattigheter` SET `superadmin` = '1', `kontoID` = '". $row2["id"] ."' WHERE `kundrattigheter`.`id` = $id");
                }

                // Skapar API-nyckel //

                $rattighetId = $_POST['id'];

                $nyckel = slumplosen(16);

                $skapaAPI = "INSERT INTO api(rattighetId, nyckel) VALUES ('$rattighetId','$nyckel')";

                $conn->query($skapaAPI);

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
        }
        
    }
    else{
        header('location: ../index.php?funktion=skapaKonto?status=error?reason=usernameTaken');
    }
    $conn->close();
    
}



<?php 

session_start();
include("../../Databas/dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'skapaKonto':
                skapaKonto($conn);
                break;

            default:    
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
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

        $sql= "INSERT INTO anvandare(anamn, losenord, salt) VALUES ('$username','$hashed_password','$salt'";
        var_dump($sql);

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

                header('location: ../index.php?funktion=skapaKonto?status=success');
            }
        }
        
    }
    else{
        header('location: ../index.php?funktion=skapaKonto?status=error?reason=usernameTaken');
    }
    $conn->close();
    
}



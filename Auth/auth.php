<?php

function login($anamn, $password){
    include("../Databas/dbh.inc.php");

    $sql = "SELECT * FROM tp_admin where anamn='{$anamn}'";
    $result = $conn->query($sql);

    $row = mysqli_fetch_assoc($result);

    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        echo "CRYPT_BLOWFISH is enabled!<br>";
    } else {
        echo "CRYPT_BLOWFISH is NOT enabled!";
    }

    $Blowfish_Pre = '$2a$10$';
    $Blowfish_End = '$';

    $bcrypt_salt = $Blowfish_Pre . $row["salt"] . $Blowfish_End;
    $hashed_password = crypt($password, $bcrypt_salt);


    if($hashed_password == $row["losenord"]){
       return true;
    }else{
       return false;
    }

}

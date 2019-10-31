<?php

session_start();

if(isset($_POST["anvandarnamn"]) && isset($_POST["losenord"])){

      include("../Databas/dbh.inc.php");

      $anamn = $_POST["anvandarnamn"];
      $password = $_POST["losenord"];

      $sql = "SELECT id, salt, losenord,anamn from anvandare where anamn='{$anamn}'";
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
        $_SESSION["UID"] = $row["id"];
      }

}

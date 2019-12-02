<?php


    include("../Databas/dbh.inc.php");

    $tjanst = $_POST['tjanst'];
    $anamn = $_POST['anamn'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM anvandare where anamn='{$anamn}'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $Blowfish_Pre = '$2a$10$';
    $Blowfish_End = '$';
    
    $anvandarId = $row['id'];
    

    $bcrypt_salt = $Blowfish_Pre . $row["salt"] . $Blowfish_End;
    $hashed_password = crypt($password, $bcrypt_salt);

    if($hashed_password == $row["losenord"]){
        if($tjanst == 'blogg'){
            $blogg_sql = "SELECT * FROM blogg where anvandarId='{$anvandarId}'";
            $bloggRes = $conn->query($blogg_sql);
            $bloggRow = mysqli_fetch_assoc($bloggRes);
            $bloggId = $bloggRow['tjanstId'];//id

            $verifyJson = array('success' => true, 'anamn' => $anamn, 'losenord' => $password,'bloggId' => "$bloggId"); 
        }
        else if($tjanst == 'wiki' || $tjanst == 'kalender'){
            $anvandarroll_sql = "SELECT * FROM anvandarroll where anvandarId='{$anvandarId}'";
            $anvandarrollRes = $conn->query($anvandarroll_sql);
            $anvandarrollRow = mysqli_fetch_assoc($anvandarrollRes);
            $anvandarroll = $anvandarrollRow['rollId'];

            $roll_sql = "SELECT * FROM roll where id='{$anvandarroll}'";
            $rollRes = $conn->query($roll_sql);
            $rollRow = mysqli_fetch_assoc($rollRes);
            $roll = $rollRow['rollNamn'];

            $verifyJson = array('success' => true, 'anamn' => $anamn, 'losenord' => $password,'roll' => "$roll");
        }
    }else{
        $verifyJson = array('success' => false, 'reason' => 'Wrong credentials');
    }

    echo json_encode($verifyJson);  









?>
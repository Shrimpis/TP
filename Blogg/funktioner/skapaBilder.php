<?php

$response = new stdClass();
$mal_dir = "bilder/";

$mal_fil = $mal_dir . basename($_FILES["file"]["name"]);

$uppladningOk = 1;

$bildFilTyp = strtolower(pathinfo($mal_fil,PATHINFO_EXTENSION));


if(!file_exists($mal_dir)){
    mkdir($mal_fil,0777,true);
}

if(isset($_POST["submit"])){
    $kontroll = getimagesize($_FILES["file"]["tmp_name"]);

    if($kontroll !== false){

        $uppladningOk = 1;
    }else{
        $uppladningOk  = 0;

    }

}

//om filen redan finns
if(file_exists($mal_fil)){
    $uppladningOk = 0;
    $response->status = "Failure";
    $response->resp = "Fil finns redan";
}

//Max storlek på bild
if($_FILES["file"]["size"] > 500000){

    $uppladningOk = 0;

}

echo $bildFilTyp."afedsefda";
//Kollar så att det är giltiga fil extensions
if($bildFilTyp != "jpg" && $bildFilTyp != "png" && $bildFilTyp != "gif" && $bildFilTyp != "jpeg"){
    $uppladningOk = 0;
    $response->status = "Failure";
    $response->resp = "Fel bildformat";
}

//kollar om det dök upp något fel annars går den vidare
if($uppladningOk == 0){

}else{
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $mal_fil)){


        $response->status = "success";
        $response->resp ="http://10.130.216.101/TP/Blogg/funktioner/". $mal_fil;


    }else{

    }
}


$response = json_encode($response);
echo $response;

<?php

include("../../Databas/dbh.inc.php");
include("../../json/felhantering.php");
include '../../api_anvandare.php';

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['sidId'])){
    
    sidVersion(getAnvandare($conn), $_POST['sidId'], $conn);
}

function sidVersion($anvandarId, $sidId,$conn){
    $sidversion= $conn->query('select * from sidversion where sidId='.$sidId);
    $wikisidor= $conn->query('select * from wikisidor where id='.$sidId);

    $sidVersioner;
    $i=0;

    while($row = $sidversion->fetch_assoc()){
        $sidVersioner[$i]=array('id'=>$row["id"],'sidId'=>$row['sidId'],'godkantAv'=>$row['godkantAv'],'bidragsgivare'=>$row["bidragsgivare"],'titel'=>$row["titel"],'innehall'=>$row["innehall"], 'datum'=>$row["datum"]);
        $i++;
    }

    $json= json_encode($sidVersioner);

    echo $json;

    if(!isset($sidVersioner)){
        hantering('400','fel med hämting av data eller så har du inte åtkomst till denna sidversion');
        return;
    }

}

?>
<?php

$conn=new mysqli("localhost","root","","the_provider");
$conn->set_charset("utf8");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_GET['sidId'])){
    
    sidVersion($_GET['sidId'],$conn);
}

function sidVersion($sidId,$conn){
    $sidversion= $conn->query('select * from sidversion where sidId='.$sidId);
    $wikisidor= $conn->query('select * from wikisidor where id='.$sidId);

    $sidVersioner;
    $i=0;
    while($row = $sidversion->fetch_assoc()){
        $sidVersioner[$i]=array('id'=>$row["id"],'godkantAv'=>$row["godkantAv"],'bidragsgivare'=>$row["bidragsgivare"],'titel'=>$row["titel"],'innehall'=>$row["innehall"], 'datum'=>$row["datum"]);
        $i++;
    }

    $json= json_encode($sidVersioner);

    echo $json;

}

?>
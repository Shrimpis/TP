<?php

nekaUppdatering();
function nekaUppdatering(){

include("dbh.inc.php");
if(isset($_POST['sidId'])&&isset($_POST['nekadAv'])){
    $sidID = $_POST['sidId'];
    $nekadAv = $_POST['nekadAv'];
    $anledning = $_POST['anledning'];

    $get_data=$conn->query("SELECT * FROM wikiuppdatering WHERE id='{$sidID}'");
    $row = $get_data->fetch_assoc();
    $datum = date("Y-m-d H:i");
    $bidragsgivare = $row['bidragsgivare'];
    $titel = $row['titel'];
    $innehall = $row['innehall'];
    $nekaUppdatering = "INSERT INTO nekadwikiuppdatering(sidId, bidragsgivare, nekadAv, titel, innehall, anledning, datum) VALUES('$sidID', '$bidragsgivare', '$nekadAv', '{$titel}', '{$innehall}', '{$anledning}', '$datum')";
    $tabortuppdatering = "DELETE FROM wikiuppdatering WHERE id='{$sidID}'";
    if(mysqli_query($conn, $nekaUppdatering)&&mysqli_query($conn, $tabortuppdatering)){
    
    
    $nekadJson = array(
        'code'=> '202',
        'status'=> 'Accepted',
        'msg' => 'sida denied',
        'sida' => array(
            'sidId'=>$sidID
        )
    );
    
    echo json_encode($nekadJson);
    
    
    }
    else{
        $nekadJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'sida' => array(
                'sidId'=>$sidID
            )
        );
        
        echo json_encode($nekadJsonError);
       
    }

}

$conn->close();

}

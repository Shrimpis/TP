<?php

nekaUppdatering();
function nekaUppdatering(){

include("dbh.inc.php");
if(isset($_POST['sidId'])&&isset($_POST['denier'])){
    $sidID = $_POST['sidId'];
    $denying_me_the_rank_of_master = $_POST['denier'];
    $its_reason_then = $_POST['reason'];
}
$get_data=$conn->query("SELECT * FROM wikiuppdatering WHERE id='{$sidID}'");
$row = $get_data->fetch_assoc();
$datum = date("Y-m-d H:i");
$badcontributor = $row['bidragsgivare'];
$titel = $row['titel'];
$innehall = $row['innehall'];
$nekaUppdatering = "INSERT INTO nekadwikiuppdatering(sidId, bidragsgivare, nekadAv, titel, innehall, anledning, datum) VALUES('$sidID', '$badcontributor', '$denying_me_the_rank_of_master', '{$titel}', '{$innehall}', '{$its_reason_then}', '$datum')";
$tabortuppdatering = "DELETE FROM wikiuppdatering WHERE id='{$sidID}'";
if(mysqli_query($conn, $nekaUppdatering)&&mysqli_query($conn, $tabortuppdatering)){


$nekadJson = array(
    'code'=> '202',
    'status'=> 'Accepted',
    'msg' => 'sida nekad',
    'sida' => array(
        'sidId'=>$sidID
    )
);

echo json_encode($nekadJson);


}
else{
    $nekaderrorJson = array(
        'code'=> '400',
        'status'=> 'Bad Request',
        'msg' => 'Could not execute',
        'sida' => array(
            'sidId'=>$sidID
        )
    );
    
    echo json_encode($nekadJson);
   
}



$conn->close();

}

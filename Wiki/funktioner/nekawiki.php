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
mysqli_query($conn, $nekaUppdatering);
$conn->close();

}

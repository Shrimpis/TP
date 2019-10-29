<?php

include('dbh.inc.php');

if(isset($_GET["eventID"]) && isset($_GET["kalenderIDS"])){
$jsonResp;
$jsonRespBody = Array();
$fullResponse = new stdClass();;
$completresponse;
$ok = true;
$event = $_GET["eventID"];
$kalenders = $_GET["kalenderIDS"];

for($i = 0; i < count($kalender); $i++){
  $jsonResp = new stdClass();
  $kalender = $kalenders[$i];

  $sql = "INSERT INTO kalenderevent(kalenderId,eventId) VALUES($kalender[$i], $event)";

  if(mysqli_query($conn,$sql)){

    $jsonResp->kod = "200";
    $jsonResp->status = "OK";
    $jsonResp->msg = "Inbjudan skickad";
    $jsonResp->event = $event;
    $jsonResp->kalender = $kalender;

    $jsonRespBody[] = $jsonResp;
  }else{

    if($ok){
      $ok = false;
    }

    $jsonResp->kod = "400";
    $jsonResp->status = "Dålig begäran";
    $jsonResp->msg = "Event eller person kunde inte hittas";
    $jsonResp->event = $event;
    $jsonResp->kalender = $kalender;

    $jsonRespBody[] = $jsonResp;
  }
}

if($ok){
  $fullResponse->kod = "200";
  $fullResponse->status = "OK";
  $fullResponse->msg = "Alla inbjudningar har skickats utan problem";
  $fullResponse->inbjudningar = $jsonRespBody;
}else{
  $fullResponse->kod = "400";
  $fullResponse->status = "Dålig begäran";
  $fullResponse->msg = "En eller flera inbjudningar kunde inte skickas";
  $fullResponse->inbjudningar = $jsonRespBody;

}



}else{

$fullResponse->kod = "400";
$fullResponse->status = "Dålig begäran";
$fullResponse->msg  = "Felaktiga parametrar";

}

$completresponse = json_encode($fullResponse);

echo $completresponse;

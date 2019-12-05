<?php
// Funktioner för att skapa
session_start();
include("../../json/felhantering.php");
include('../../Databas/dbh.inc.php');
if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom


  $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
  $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";

  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);

    if($count == 1){
        switch ($_POST['funktion']) {
            case 'skapaKalender':
                skapaKalender($conn);
                break;
            case 'skapaKalendersida':
                skapaKalendersida($conn);
                break;
            case 'skapaKalenderevent':
                skapaKalenderevent($conn);
                break;
            case 'bjudin':
                bjudin($conn);
                break;
            default:
                hantering('400','ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.');
                break;
        }
    }
    else{
        hantering('401','Behörighet saknas');
    }
}
else{
    hantering('401','Behörighet saknas, tom api');
}
function skapaKalender($conn){
    //-include('dbh.inc.php');
    $anvandarId = $_POST['anvandarId'];
    $titel = $_POST['titel'];



            $skapatjanst = "INSERT INTO tjanst(anvandarId,titel,privat) VALUES($anvandarId,'{$titel}',1)";
            if(mysqli_query($conn, $skapatjanst)){

                $sql = "INSERT INTO kalender(tjanstId) VALUES(". mysqli_insert_id($conn).")";
                   $conn->query($sql);


                   hantering('202','Ny kalender skapad');
            }
            else{

                hantering('400','kunde inte exekvera');
            }



    $conn->close();
}
function skapaKalendersida($conn){
    //-include('dbh.inc.php');
    if(isset($_POST['anvandarId'])&&isset($_POST['kalenderId'])){
    $anvandarId = $_POST['anvandarId'];
    $kalenderId = $_POST['kalenderId'];
    }
    $get_kalid = $conn->query("SELECT * FROM kalender where tjanstId = $kalenderId");
    $row = $get_kalid->fetch_assoc();
    $kalid = $row['id'];
    $skapasida = "INSERT INTO kalendersida(anvandarId,kalenderId) VALUES($anvandarId,$kalid)";
    if(mysqli_query($conn, $skapasida)){
        hantering('202','Ny kalendersida skapad');
    }
    else{
        hantering('400','kunde inte exekvera');
    }
}
function skapaKalenderevent($conn){
    //-include('dbh.inc.php');
    if(isset($_POST['titel'])&&isset($_POST['startTid'])&&isset($_POST['slutTid'])&&isset($_POST['anvandarId'])&&isset($_POST['innehall'])&&isset($_POST['kalenderId'])){
    $titel = $_POST['titel'];
    $innehall = $_POST['innehall'];
    $start = $_POST['startTid'];
    $anvandarId = $_POST['anvandarId'];
    $slut = $_POST['slutTid'];
    $kalenderId = $_POST['kalenderId'];
    }
        mysqli_query($conn,"INSERT INTO event(skapadAv,titel,innehall,startTid,slutTid) VALUES($anvandarId,'{$titel}','{$innehall}','{$start}','{$slut}')");

        Denna bortkommenterade kod gör samma sak som mysqli_insert_id men om fler funktioner använder mysqli kanske det inte fungerar, då kan vi behöva använda denna kod igen. Däremot kan det bli fel med denna kod om en person lyckas dubbelskicka ett event.
        $sql="SELECT * FROM event WHERE skapadAv = $anvandarId AND titel= '{$titel}' AND startTid = '{$start}'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
        $evId = $row['id'];

        }

        $skapakalev = "INSERT INTO kalenderevent(kalenderId,eventId,status) VALUES($kalenderId,mysqli_insert_id($conn),0)";


    if(mysqli_query($conn, $skapakalev)){
        hantering('202','Ny event skapad');

    }
    else{
        hantering('400','kunde inte exekvera');
    }
}
function bjudin($conn){
    if(isset($_GET["eventID"]) && isset($_GET["kalenderIDS"])){
        $jsonResp;
        $jsonRespBody = Array();
        $fullResponse = new stdClass();;
        $completresponse;
        $ok = true;
        $event = $_GET["eventID"];
        $kalenders = $_GET["kalenderIDS"];
        for($i = 0; i < count($kalenders); $i++){
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
}

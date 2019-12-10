<html><head><script src="../js/status.js"></script></head></html>
<?php

// Funktioner för att redigera

session_start();

include('../../Databas/dbh.inc.php');
include("../../json/felhantering.php");
if(!empty($_POST['nyckel'])){ // Kollar efter om api-nyckeln är tom
  var_dump($_POST['nyckel']);
  
  $apikey = mysqli_real_escape_string($conn,$_POST['nyckel']);
  $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
  
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);

  if($count == 1){
    switch ($_POST['funktion']) {

      case 'aktiveraEvent':
        aktiveraEvent($conn);
        break;
      case 'redigeraEvent':
        redigeraEvent($conn);
        break;
      case 'status':
        status($conn);
        break;

      default:
        hantering('400','ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.',);
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

        function aktiveraEvent($conn){
            
            if(isset($_POST['id']) ){
                $id = $_POST['id'];
            }
            $event = $conn->query('select * from event where id ='.$id);
        
                while($row = $event->fetch_assoc()){
                    $aktiv=$row["aktiv"];
                    if($aktiv==0){
                        $sql= "UPDATE event SET aktiv = '1' WHERE id = $id ";
                        $conn->query($sql);
                        break;
                    }
                    else if($aktiv==1){
                        $sql= "UPDATE event SET aktiv = '0' WHERE id = $id ";
                        $conn->query($sql);
                        
                       break;
                    }

                    else{
                        hantering('400','Event id finns inte i databasen.',);
                        break;
                    }
                }
                
                    
        }

        function redigeraEvent($conn){
            
            if(isset($_POST['id']) && isset($_POST['titel']) && isset($_POST['innehall']) && isset($_POST['startTid']) && isset($_POST['slutTid']) ){
                $id = $_POST['id'];
                $titel = $_POST['titel'];
                $innehall = $_POST['innehall'];
                $startTid = $_POST['startTid'];
                $slutTid = $_POST['slutTid'];
            }
            $event = $conn->query('select * from event where id ='.$id);
        
                while($row = $event->fetch_assoc()){
                    $eventId=$row["id"];
                    if($id==$eventId){
                        
                        $sql= "UPDATE event SET titel='$titel', innehall='$innehall', startTid='$startTid', slutTid='$slutTid' WHERE id =$id ";
                        $conn->query($sql);
                        break;
                    }
                    
                    else{
                        hantering('400','Event id finns inte i databasen',);
                        break;
                    }
                }
                
                    
        }
        function status($conn){
            $completresponse = Array();
            $jsonRespBody = Array();
            $jsonResp;
            
            $_SESSION["UID"] = 1;
            
            if (!$conn) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            
            mysqlI_set_charset($conn, "utf8mb4");
            
            if(isset($_SESSION["UID"]) && isset($_POST["status"]) && isset($_POST["kalenderID"])){
            
              echo "test";
              if(isset($_POST["anledning"]) && $_POST["status"] == 2){
            
                $status = $_POST["status"];
                $anledning = $_POST["anledning"];
                $id = $_POST["kalenderID"];
            
                $sql = "update kalenderevent set anledning='{$anledning}', status=".$status." where id=".$id;
                if(mysqli_query($conn, $sql)){
                  $conn->query($sql);
            
                  $completresponse->code = "200";
                  $completresponse->status = "OK";
                  $completresponse->msg = "Lyckades";
            
                }
                header("Refresh:0; url=status.php");
            
              }else if($_POST["status"] == 2){
            
                    $status = $_POST["status"];
                    $id = $_POST["kalenderID"];
            
                    $sql = "update kalenderevent set status=".$status." where id=".$id;
                    if(mysqli_query($conn, $sql)){
                      $conn->query($sql);
                      $completresponse->code = "200";
                      $completresponse->status = "OK";
                      $completresponse->msg = "Lyckades";
                    }
                    header("Refresh:0; url=status.php");
              }else{
            
                    $status = $_POST["status"];
                    $id = $_POST["kalenderID"];
            
                    $sql = "update kalenderevent set status=".$status." where id=".$id;
                    if(mysqli_query($conn, $sql)){
                      $conn->query($sql);
                      $completresponse->code = "200";
                      $completresponse->status = "OK";
                      $completresponse->msg = "Lyckades";
                    }
                    header("Refresh:0; url=status.php");
              }
            
            
            }else if(isset($_SESSION["UID"])){
            
            $sql = "SELECT *from kalendersida where anvandarId=".$_SESSION["UID"];
            
            if(mysqli_query($conn, $sql)){
              $result = $conn->query($sql);
            }
            
            $kalender = $result->fetch_assoc();
            
            $id = $kalender["kalenderId"];
            
              $sql = "SELECT event.titel, event.startTid, event.slutTid, anvandare.anamn, kalenderevent.id as 'kalenderID' FROM kalenderevent inner join event on event.ID=kalenderevent.eventId inner join anvandare on event.skapadAv=anvandare.Id where kalenderId = $id AND status=0";
              if(mysqli_query($conn, $sql)){
                $result = $conn->query($sql);
              }
            
            
              while($row = mysqli_fetch_assoc($result)){
                $jsonResp = new stdClass();
                $jsonResp->code = "200";
                $jsonResp->status ="OK";
                $jsonResp->msg = "Lyckades";
                $jsonResp->title = $row["titel"];
                $jsonResp->namn = $row["anamn"];
                $jsonResp->start = $row["startTid"];
                $jsonResp->slut = $row["slutTid"];
                $jsonResp->ID = $row["kalenderID"];
            
                $jsonRespBody[] = $jsonResp;
            
                echo "du har blivit inbjuden till ".$row["titel"]." av ".$row["anamn"]." klockan: ".$row["startTid"]." : ".$row["slutTid"] ."<br>";
                echo "<button onclick=statusAndra(2,".$row["kalenderID"].")>Neka</button> <button onclick=statusAndra(1,".$row["kalenderID"].")>acceptera</button><br>";
              }
              $completresponse->code = "200";
              $completresponse->status = "OK";
              $completresponse->msg = "Lyckades";
              $completresponse->events = $jsonRespBody;
            
            
            }else{
              $completresponse->code = "400";
              $completresponse->status = "Dålig begäran";
              $completresponse->msg = "För få argument";
            }
            
            
            $json = json_encode($completresponse);
            
            echo $json;
            }
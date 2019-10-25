<?php
session_start();
include "./dbh.inc.php";

$_SESSION["UID"] = 1;

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

mysqlI_set_charset($conn, "utf8mb4");

if(isset($_SESSION["UID"])){

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

    echo "du har blivit inbjuden till ".$row["titel"]." av ".$row["anamn"]." klockan: ".$row["startTid"]." : ".$row["slutTid"] ."<br>";
    echo "<button onclick=status(2,".$row["kalenderID"].")>Neka</button> <button onclick=status(1,".$row["kalenderID"].")>acceptera</button><br>";
  }


}else if(isset($_SESSION["UID"]) && isset($_GET["status"]) && isset($_GET["kalenderID"])){

  echo "test";
  if(isset($_GET["anledning"]) && $_GET["status"] == 2){

    $status = $_GET["status"];
    $anledning = $_GET["anledning"];
    $id = $_GET["kalenderID"];

    $sql = "update kalenderevent set anledning='{$anledning}', status=".$status." where id=".$id;
    if(mysqli_query($conn, $sql)){
      $conn->query($sql);
    }
    header("Refresh:0");

  }else if($_GET["status"] == 2){

        $status = $_GET["status"];
        $id = $_GET["kalenderID"];

        $sql = "update kalenderevent set status=".$status." where id=".$id;
        if(mysqli_query($conn, $sql)){
          $conn->query($sql);
        }
        header("Refresh:0");
  }else{

        $status = $_GET["status"];
        $id = $_GET["kalenderID"];

        $sql = "update kalenderevent set status=".$status." where id=".$id;
        if(mysqli_query($conn, $sql)){
          $conn->query($sql);
        }
        header("Refresh:0");
  }


}

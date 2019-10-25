<?php
session_start();
include("./dbh.inc.php");
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

  $sql = "SELECT * FROM kalenderevent inner join event on event.ID=kalenderevent.eventId inner join anvandare on event.skapadAv=anvandare.Id where kalenderId = $id AND status=0";
  if(mysqli_query($conn, $sql)){
    $result = $conn->query($sql);
  }
  while($row = mysqli_fetch_assoc($result)){

    echo "du har blivit inbjuden till ".$row["titel"]." av ".$row["anamn"]." klockan: ".$row["startTid"]." : ".$row["slutTid"] ."<br>";
    echo "<button>Neka</button>   <button>Accpetera</button><br>";
  }

}

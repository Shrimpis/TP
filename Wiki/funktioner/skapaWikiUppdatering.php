<?php

function skapaUppdatering($conn){

    include('dbh.inc.php');

    if(isset($_POST['wikiId']) && isset($_POST['sidId']) && isset($_POST['bidragsgivare']) &&isset($_POST['titel']) &&isset($_POST['innehall'])){
        $wikiId= $_POST['wikiId'];
        $sidId= $_POST['sidId'];
        $bidragsGivare= $_POST['bidragsgivare'];
        $titel= $_POST['titel'];
        $innehall= $_POST['innehall'];

        $anvandarroll = $conn->query('select * from anvandarroll where anvandarId='.$bidragsGivare);
        if($sidId!=""){
            $wikissId = $conn->query('select * from wikisidor where id='.$sidId);
            $row1 = $wikissId->fetch_assoc();
            $sidaId=$row1["id"];
        }

        $row = $anvandarroll->fetch_assoc();
        $roll=$row["rollId"];

        $date= date("Y-m-d H:i");
            if(($roll=="1" || $roll=="3") && $sidId==""){
                $sql= "INSERT INTO wikisidor(wikiId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$bidragsGivare','$bidragsGivare', '$titel','$innehall','$date')";
                $conn->query($sql);
            }
            else if(($roll=="1" || $roll=="3") && $sidId==$sidaId){
                $sql= "UPDATE wikisidor SET godkantAv='$bidragsGivare',bidragsgivare='$bidragsGivare',titel='$titel',innehall='$innehall',datum='$date' WHERE id=$sidId";
                $conn->query($sql);
            }
            else if(($roll!="1" || $roll!="3") && $sidId==""){
                $sql= "INSERT INTO wikiuppdatering(wikiId, sidId, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$sidId','$bidragsGivare', '$titel','$innehall','$date')";
                $conn->query($sql);
            }
            else{
                $sql= "INSERT INTO wikiuppdatering(wikiId, sidId, bidragsgivare, titel, innehall, datum) VALUES ('$wikiId','$sidId','$bidragsGivare', '$titel','$innehall','$date')";
                $conn->query($sql);
            }
        
    }
        
    $conn->close();

}

?>
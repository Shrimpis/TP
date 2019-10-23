<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'doljWiki':
                doljWiki();
                break;
            case 'doljwiksida':
                doljWikiSida();
                break;
            case 'godkannUppdatering':
                godkannUppdatering();
                break;
            case 'nekaUppdatering':
                nekaUppdatering();
                break;
            case 'lasaWikiSida':
                lasaSida();
                break;
            case 'privatiseraWiki':
                privatiseraWiki();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();


function doljWiki(){
    include('dbh.inc.php');
    $wikiId = $_POST['wikiId'];


        $redan_dolt = $conn->query("SELECT * FROM wiki WHERE tjanstId ='{$wikiId}'");

        $row = $redan_dolt->fetch_assoc();
        $dolt=$row["dolt"];
           
            if($dolt==0){
                 $conn->query("UPDATE wiki SET dolt=1 WHERE tjanstId = '{$wikiId}'");
                 

                $hideWikiJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'wiki hidden',
                    'wiki' => array(
                        'wikiId'=>$wikiId
                    )
                );
                
                echo json_encode($hideWikiJson);

            }
            else if($dolt==1){
                $conn->query("UPDATE wiki SET dolt=0 WHERE tjanstId = '{$wikiId}'");

                $unhideWikiJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'wiki now public',
                    'wiki' => array(
                        'wikiId'=>$wikiId
                    )
                );
                
                echo json_encode($unhideWikiJson);

            }
            else{
                $hideWikiJsonError = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'wiki' => array(
                        'wikiId'=>$wikiId 
                    )
                );
                
                echo json_encode($hideWikiJsonError);

            }
        
    $conn->close();

}

function doljWikiSida(){

    include('dbh.inc.php');

    if(isset($_POST['id']) ){
        $id = $_POST['id'];
        
        $wikiSida = $conn->query('select * from wikisidor where id ='.$id);

        $row = $wikiSida->fetch_assoc();
        $dolj=$row["dolt"];

        if($dolj==0){
            $sql= "UPDATE wikisidor SET dolt = '1' WHERE id = $id ";
            $conn->query($sql);
           
        }
        else if($dolj==1){
            $sql= "UPDATE wikisidor SET dolt = '0' WHERE id = $id ";
            $conn->query($sql);

        }

    }

    $conn->close();
    
}

function godkannUppdatering(){
    include("dbh.inc.php");
    if(isset($_POST['uppdateringid']) && isset($_POST['sidId']) && isset($_POST['godkantAv'])){

        $uppdateringId = $_POST['uppdateringid'];
        $sidId = $_POST['sidId'];
        $godkantAv = $_POST['godkantAv'];

        if($sidId != 0){

            $skickaVersion = "INSERT INTO sidversion(sidId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES((SELECT id FROM wikisidor WHERE id = $sidId),
            (SELECT godkantAv FROM wikisidor WHERE id = $sidId), (SELECT bidragsgivare FROM wikisidor WHERE id = $sidId), (SELECT titel FROM wikisidor WHERE id = $sidId),
            (SELECT innehall FROM wikisidor WHERE id = $sidId), (SELECT datum FROM wikisidor WHERE id = $sidId))";

            $uppdateraSida = "UPDATE wikisidor SET godkantAv = $godkantAv, bidragsgivare = (SELECT bidragsgivare FROM wikiuppdatering WHERE id = $uppdateringId),
            titel = (SELECT titel FROM wikiuppdatering WHERE id = $uppdateringId), innehall = (SELECT innehall FROM wikiuppdatering WHERE id = $uppdateringId),
            datum = (SELECT datum FROM wikiuppdatering WHERE id = $uppdateringId) WHERE id = $sidId";
            
            $taBortUppdatering = "DELETE FROM wikiuppdatering WHERE id = $sidId";

            if(mysqli_query($conn, $skickaVersion)){
                $skickaVersionJson = array(
                    'code' => '201',
                    'status' => 'Created',
                    'msg' => 'Sidversion Created',
                    'sidversion' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($skickaVersionJson);
    
            }else{
                $skickaVersionJsonError = array(
                    'code' => '400',
                    'status' => 'Bad Request',
                    'msg' => 'Could not execute',
                    'sidversion' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($skickaVersionJsonError);
            }
    
            if(mysqli_query($conn, $uppdateraSida)){
                $uppdateraSidaJson = array(
                    'code' => '201',
                    'status' => 'Created',
                    'msg' => 'Update Created',
                    'wikisidor' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($uppdateraSidaJson);
    
            }else{
                $uppdateraSidaJsonError = array(
                    'code' => '400',
                    'status' => 'Bad Request',
                    'msg' => 'Could not execute',
                    'wikisidor' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($uppdateraSidaJsonError);
            }
            if(mysqli_query($conn, $taBortUppdatering)){
                $taBortUppdateringJson = array(
                    'code' => '204',
                    'status' => 'No Content',
                    'msg' => 'Update Deleted',
                    'wikiuppdatering' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($taBortUppdateringJson);
    
            }else{
                $taBortUppdateringJsonError = array(
                    'code' => '400',
                    'status' => 'Bad Request',
                    'msg' => 'Could not execute',
                    'wikiuppdatering' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($taBortUppdateringJsonError);
            }
        }else if($sidId == 0){
            $nyWikiSida = "INSERT INTO wikisidor(wikiId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES((SELECT wikiId FROM wikiuppdatering WHERE id = $uppdateringId), $godkantAv,
            (SELECT bidragsgivare FROM wikiuppdatering WHERE id = $uppdateringId), (SELECT titel FROM wikiuppdatering WHERE id = $uppdateringId), (SELECT innehall FROM wikiuppdatering WHERE id = $uppdateringId), 
            (SELECT datum FROM wikiuppdatering WHERE id = $uppdateringId))";
            echo $nyWikiSida;
            if(mysqli_query($conn, $nyWikiSida)){
                $nyWikiSidaJson = array(
                    'code' => '201',
                    'status' => 'Created',
                    'msg' => 'New Page Created',
                    'wikisidor' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($nyWikiSidaJson);
            }else{
                $nyWikiSidaJsonError = array(
                    'code' => '400',
                    'status' => 'Bad Request',
                    'msg' => 'Could not execute nyWikiSida',
                    'wikiuppdatering' => array(
                        'uppdateringId' => $uppdateringId,
                        'sidId' => $sidId,
                        'godkantAv' => $godkantAv
                    )
                );
                echo json_encode($nyWikiSidaJsonError);
            }
        }
    }
    $conn->close();
}

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

    function lasaSida(){

        include('dbh.inc.php');

        if(isset($_POST['id']) ){
            $id = $_POST['id'];

            $wikiSida = $conn->query('select * from wikisidor where id ='.$id);
    
            $row = $wikiSida->fetch_assoc();
            $lasa=$row["last"];

            if($lasa==0){
                $sql= "UPDATE wikisidor SET wikisidor.last = '1' WHERE id = $id ";
                $conn->query($sql);
               
            }
            else if($lasa==1){
                $sql= "UPDATE wikisidor SET wikisidor.last = '0' WHERE id = $id ";
                $conn->query($sql);

            }

        }

        $conn->close();
        
    }
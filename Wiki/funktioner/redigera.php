<?php

// Funktioner för att ta bort

session_start();

include('./Databas/dbh.inc.php');   

        switch ($_GET['funktion']) {

            case 'doljWiki':
                doljWiki($conn);
                break;
            case 'doljWikiSida':
                doljWikiSida($conn);
                break;
            case 'godkannUppdatering':
                godkannUppdatering($conn);
                break;
            case 'nekaUppdatering':
                nekaUppdatering($conn);
                break;
            case 'lasaWikiSida':
                lasaWikiSida($conn);
                break;
            case 'privatiseraWiki':
                privatiseraWiki($conn);
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }


function doljWiki($conn){
    //-include('dbh.inc.php');
    $wikiId = $_GET['wikiId'];


        $redan_dolt = $conn->query("SELECT * FROM wiki WHERE id ='{$wikiId}'");

        $row = $redan_dolt->fetch_assoc();
        $dolt=$row["dolt"];
           
            if($dolt==0){
                 $conn->query("UPDATE wiki SET dolt=1 WHERE id = '{$wikiId}'");
                 

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
                $conn->query("UPDATE wiki SET dolt=0 WHERE id = '{$wikiId}'");

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

function doljWikiSida($conn){

    //-include('dbh.inc.php');

    var_dump($conn);
    if(isset($_GET['id']) ){
        $id = $_GET['id'];
        
        $wikiSida = $conn->query('select * from wikisidor where id ='.$id);

        $row = $wikiSida->fetch_assoc();
        $dolj=$row["dolt"];

        if($dolj==0){
            $sql= "UPDATE wikisidor SET dolt = 1 WHERE id = $id ";
            $conn->query($sql);
           
        }
        else if($dolj==1){
            $sql= "UPDATE wikisidor SET dolt = 0 WHERE id = $id ";
            $conn->query($sql);

        }

    }

    $conn->close();
    
}

function godkannUppdatering($conn){

    
    //-include("dbh.inc.php");
    if(isset($_GET['uppdateringid']) && isset($_GET['sidId']) && isset($_GET['godkantAv'])){
        $uppdateringId = $_GET['uppdateringid'];
        $sidId = $_GET['sidId'];
        $godkantAv = $_GET['godkantAv'];

        if($sidId != 0){
            
            $skickaVersion = "INSERT INTO sidversion(sidId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES((SELECT id FROM wikisidor WHERE id = $sidId),
            (SELECT godkantAv FROM wikisidor WHERE id = $sidId), (SELECT bidragsgivare FROM wikisidor WHERE id = $sidId), (SELECT titel FROM wikisidor WHERE id = $sidId),
            (SELECT innehall FROM wikisidor WHERE id = $sidId), (SELECT datum FROM wikisidor WHERE id = $sidId))";

            $uppdateraSida = "UPDATE wikisidor SET godkantAv = $godkantAv, bidragsgivare = (SELECT bidragsgivare FROM wikiuppdatering WHERE id = $uppdateringId),
            titel = (SELECT titel FROM wikiuppdatering WHERE id = $uppdateringId), innehall = (SELECT innehall FROM wikiuppdatering WHERE id = $uppdateringId),
            datum = (SELECT datum FROM wikiuppdatering WHERE id = $uppdateringId) WHERE id = $sidId";
            
            $taBortUppdatering = "DELETE FROM wikiuppdatering WHERE id = $uppdateringId";

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
            $taBortUppdatering = "DELETE FROM wikiuppdatering WHERE id = $uppdateringId";


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

function nekaUppdatering($conn){

    //-include("dbh.inc.php");
    if(isset($_GET['id'])&&isset($_GET['nekadAv'])){
        $id = $_GET['id'];
        $nekadAv = $_GET['nekadAv'];
        if(isset($_GET['anledning'])){
            $anledning = $_GET['anledning'];
        }
        else{
            $anledning = "angavs ej";
        }
        
    
        $get_data=$conn->query("SELECT * FROM wikiuppdatering WHERE id=$id");
        $row = $get_data->fetch_assoc();
        $datum = date("Y-m-d");
        $bidragsgivare = $row['bidragsgivare'];
        $titel = $row['titel'];
        $innehall = $row['innehall'];
        $nekaUppdatering = "INSERT INTO nekadwikiuppdatering(sidId, bidragsgivare, nekadAv, titel, innehall, anledning, datum) VALUES($id, $bidragsgivare, $nekadAv, '{$titel}', '{$innehall}', '{$anledning}', '$datum')";
        $tabortuppdatering = "DELETE FROM wikiuppdatering WHERE id=$id";
        if(mysqli_query($conn, $nekaUppdatering)&&mysqli_query($conn, $tabortuppdatering)){
        
        
        $nekadJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'sida denied',
            'sida' => array(
                'sidId'=>$id
            )
        );
        
        echo json_encode($nekadJson);
        
        
        }
        else{
            echo $nekaUppdatering . " " . $tabortuppdatering . " ";
            $nekadJsonError = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Could not execute',
                'sida' => array(
                    'sidId'=>$id
                )
            );
            
            echo json_encode($nekadJsonError);
           
        }
    
    }
    
    $conn->close();
    
    }

    function lasaWikiSida($conn){

        //-include('dbh.inc.php');

        if(isset($_GET['id']) ){
            $id = $_GET['id'];

            $wikiSida = $conn->query('select * from wikisidor where id ='.$id);
    
            $row = $wikiSida->fetch_assoc();
            $lasa=$row["last"];

            if($lasa==0){
                $sql= "UPDATE wikisidor SET wikisidor.last = 1 WHERE id = $id ";
                $conn->query($sql);
               
            }
            else if($lasa==1){
                $sql= "UPDATE wikisidor SET wikisidor.last = 0 WHERE id = $id ";
                $conn->query($sql);

            }

        }

        $conn->close();
        
    }

    function privatiseraWiki($conn){
        //-include("dbh.inc.php");
        if(isset($_GET['wikiId'])&&isset($_GET['privat'])){
            $wikiId = $_GET['wikiId'];
            $privat = $_GET['privat'];   
        }
    
        $result = $conn->query("SELECT * FROM wiki where id= $wikiId ");
            $row = $result->fetch_assoc();
            $tjanstId = $row['tjanstId'];
            $uppdateraTjanst = "UPDATE tjanst SET privat = '{$privat}' WHERE id = $tjanstId ";
        
        
        
        
        if(mysqli_query($conn, $uppdateraTjanst)){
    
            $privatiseraTjanstJson = array(
                'code'=> '202',
                'status'=> 'Accepted',
                'msg' => 'tjanst har redigerats',
                'tjanst' => array(
                    'wikiId'=>$wikiId,
                )
            );
            
            echo json_encode($privatiseraTjanstJson);
        } else {
            $privatiseraTjanstJsonError = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Could not execute',
                'tjanst' => array(
                    'wikiId'=>$wikiId,
                )
            );
            
            echo json_encode($privatiseraTjanstJsonError);
        }
        $conn->close();
    }
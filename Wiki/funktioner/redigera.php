<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'hideWiki':
                hideWiki();
                break;
            case 'hidewiksida':
                hidewikside();
                break;
            case 'godkannUppdatering':
                godkannUppdatering();
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();


function hideWiki(){
    include('dbh.inc.php');
    $wikiId = $_POST['wikiId'];


        $redan_dolt = $conn->query("SELECT * FROM wiki WHERE tjanstId ='{$wikiId}'");

        $row = $redan_dolt->fetch_assoc();
        $dolt=$row["dolt"];
        while($dolt < 2){
           
            if($dolt==0){
                 $conn->query("UPDATE wiki SET dolt=1 WHERE tjanstId = '{$wikiId}'");
                 

                $hidewikiJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'wiki hidden',
                    'wiki' => array(
                        'wikiId'=>$wikiId
                    )
                );
                
                echo json_encode($hidewikiJson);

                break;
            }
            else if($dolt==1){
                $conn->query("UPDATE wiki SET dolt=0 WHERE tjanstId = '{$wikiId}'");

                $unhidewikiJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'wiki now public',
                    'wiki' => array(
                        'wikiId'=>$wikiId
                    )
                );
                
                echo json_encode($unhidewikiJson);

               break;
            }
            else{
                $censureraKommentarErrorJson = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'wiki' => array(
                        'wikiId'=>$wikiId 
                    )
                );
                
                echo json_encode($hidewikierrorJson);

               break;
            }
               
        }
        
    $conn->close();

}

function godkannUppdatering(){
    include("dbh.inc.php");
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
            $nyWikiSida = "INSERT INTO wikisidor(wikiId, godkantAv, bidragsgivare, titel, innehall, datum) VALUES((SELECT wikiId FROM wikiuppdatering WHERE id = $sidId), $godkantAv,
            (SELECT bidragsgivare FROM wikiuppdatering WHERE id = $sidId), (SELECT titel FROM wikiuppdatering WHERE id = $sidId), (SELECT innehall FROM wikiuppdatering WHERE id = $sidId), 
            (SELECT datum FROM wikiuppdatering WHERE id = $sidId)";
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
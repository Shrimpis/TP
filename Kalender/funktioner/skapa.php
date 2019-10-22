<?php

// Funktioner för att skapa

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'skapaKalender':
                skapaKalender();
                break;

            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();

function skapaKalender(){
    include('dbh.inc.php');
    $anvandarId = $_POST['anvandarId'];


        

        
        
           
            if(){
                 $conn->query("UPDATE wiki SET dolt=1 WHERE tjanstId = '{$wikiId}'");
                 

                $skapaKalenderJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'kalender skapad',
                    'wiki' => array(
                        'wikiId'=>$wikiId
                    )
                );
                
                echo json_encode($skapaKalenderJson);

            }
            else{
                $skapaKalendererrorJson = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'wiki' => array(
                        'wikiId'=>$wikiId 
                    )
                );
                
                echo json_encode($skapaKalendererrorJson);

               
            }
               
        
        
    $conn->close();

}

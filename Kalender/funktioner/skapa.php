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
    $titel = $_POST['titel'];

        

        
        
            $skapatjanst = "INSERT INTO tjanst(anvandarId,titel,privat) VALUES($anvandarId,'{$titel}',1)";
            if(mysqli_query($conn, $skapatjanst)){
                
                $sql = "INSERT INTO kalender(tjanstId) VALUES(". mysqli_insert_id($conn).")";
                   $conn->query($sql);
                

                $skapaKalenderJson = array(
                    'code'=> '202',
                    'status'=> 'Accepted',
                    'msg' => 'kalender skapad',
                    'kalender' => array(
                        'anvandarId'=>$anvandarId,
                        'titel'=>$titel,
                        'privat'=> '1'
                    )
                );
                
                echo json_encode($skapaKalenderJson);
 
                
                
            }
            else{
                
                $skapaKalendererrorJson = array(
                    'code'=> '400',
                    'status'=> 'Bad Request',
                    'msg' => 'Could not execute',
                    'kalender' => array(
                        'anvandarId'=>$anvandarId,
                        'titel'=>$titel,
                        'privat'=> '1'
                    )
                );
                
                echo json_encode($skapaKalendererrorJson);

               
            }
               
        
        
    $conn->close();

}

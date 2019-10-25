<?php

// Funktioner för att skapa

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'skapaKalender':
                skapaKalender();
                break;
            case 'skapaKalendersida':
                skapaKalendersida();
                break;
            case 'skapaKalenderevent':
                skapaKalenderevent();
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
function skapaKalendersida(){
    include('dbh.inc.php');
    if(isset($_POST['anvandarId'])&&isset($_POST['kalenderId'])){
    $anvandarId = $_POST['anvandarId'];
    $kalenderId = $_POST['kalenderId'];
    }

    $get_kalid = $conn->query("SELECT * FROM kalender where tjanstId = $kalenderId");
    $row = $get_kalid->fetch_assoc();
    $kalid = $row['id'];
    $skapasida = "INSERT INTO kalendersida(anvandarId,kalenderId) VALUES($anvandarId,$kalid)";
    if(mysqli_query($conn, $skapasida)){
        $skapaKalendersidaJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'kalendersida skapad',
            'kalendersida' => array(
                'anvandarId'=>$anvandarId,
                'kalenderId'=>$kalenderId
            )
        );
        
        echo json_encode($skapaKalendersidaJson);
    }
    else{
        $skapaKalendersidaerrorJson = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'kalendersida' => array(
                'anvandarId'=>$anvandarId,
                'kalenderId'=>$kalenderId
            )
        );
        
        echo json_encode($skapaKalendersidaerrorJson);
    }
}

function skapaKalenderevent(){
    include('dbh.inc.php');
    if(isset($_POST['titel'])&&isset($_POST['startTid'])&&isset($_POST['slutTid'])&&isset($_POST['anvandarId'])&&isset($_POST['innehall'])&&isset($_POST['kalenderId'])){
    $titel = $_POST['titel'];
    $innehall = $_POST['innehall'];
    $start = $_POST['startTid'];
    $anvandarId = $_POST['anvandarId'];
    $slut = $_POST['slutTid'];
    $kalenderId = $_POST['kalenderId'];
    }
        mysqli_query($conn,"INSERT INTO event(skapadAv,titel,innehall,startTid,slutTid) VALUES($anvandarId,'{$titel}','{$innehall}','{$start}','{$slut}')");
        /*
        Denna bortkommenterade kod gör samma sak som mysqli_insert_id men om fler funktioner använder mysqli kanske det inte fungerar, då kan vi behöva använda denna kod igen. Däremot kan det bli fel med denna kod om en person lyckas dubbelskicka ett event. 
        $sql="SELECT * FROM event WHERE skapadAv = $anvandarId AND titel= '{$titel}' AND startTid = '{$start}'";
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()){
        $evId = $row['id'];
        
        }
        */
        $skapakalev = "INSERT INTO kalenderevent(kalenderId,eventId,status) VALUES($kalenderId,". mysqli_insert_id($conn).",0)";
        
        
    if(mysqli_query($conn, $skapakalev)){
        
        $skapaKalendereventJson = array(
            'kod'=> '202',
            'status'=> 'Accepterat',
            'meddelande' => 'kalenderevent skapad',
            'kalenderevent' => array(
                'anvandarId'=>$anvandarId,
                'titel'=>$titel
            )
        );
        
        echo json_encode($skapaKalendereventJson);
    }
    else{
        
        $skapaKalendereventerrorJson = array(
            'kod'=> '400',
            'status'=> 'felaktig forfragan',
            'meddelande' => 'kunde inte exekvera',
            'kalenderevent' => array(
                'anvandarId'=>$anvandarId,
                'titel'=>$titel
            )
        );
        
        echo json_encode($skapaKalendereventerrorJson);
    }
}

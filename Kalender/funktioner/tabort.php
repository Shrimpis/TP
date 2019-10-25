<?php

// Funktioner för att ta bort

session_start();

include('./Databas/dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'tabortKalender':
                tabortKalender();
                break;
            case 'tabortEvent':
                tabortEvent($conn);
                break;
            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }




function tabortKalender(){
    //include('dbh.inc.php');
    $kalenderId = $_POST['kalenderId'];

        

        
        
        $deltjanst = "DELETE FROM tjanst WHERE id = '{$tjanstId}'";
            if(mysqli_query($conn, $deltjanst)){
                $get_result = $conn->query("SELECT * FROM kalender WHERE tjanstId = '{$tjanstId}'");

                while($row=$get_result->fetch_assoc()){
                    $id=$row['id']; 
                    $get_kalsid = $conn->query("SELECT * FROM kalendersida WHERE kalenderId = $id");
                    echo $id;
                    while($row = $get_kalsid->fetch_assoc()){
                        $kalsidID = $row['id'];
                        echo $kalsidID;
                        $get_kalevid = $conn->query("SELECT * FROM kalenderevent WHERE kalenderId = $kalsidID");
                     
                        
                        while($row = $get_kalevid->fetch_assoc()){
                            $eventId = $row['eventId'];
                            echo $eventId;
                            $conn->query("DELETE FROM event WHERE id = $eventId");
                        }
                        $conn->query("DELETE FROM kalenderevent WHERE kalenderId =$kalsidID");
                        
                    }
                    $conn->query("DELETE FROM kalendersida WHERE kalenderId = $id");
                }

                

                $sql = "DELETE FROM kalender WHERE tjanstId = '{$tjanstId}'";
                   $conn->query($sql);

                
                

                $tabortKalenderJson = array(
                    'kod'=> '202',
                    'status'=> 'Accepterad',
                    'meddelande' => 'kalender borttagen',
                    'kalender' => array(
                        'kalenderId'=>$tjanstId

                    )
                );
                
                echo json_encode($tabortKalenderJson);
 
                
                
            }
            else{
                
                $tabortKalendererrorJson = array(
                    'kod'=> '400',
                    'status'=> 'felaktig forfragan',
                    'meddelande' => 'kunde ej exekvera',
                    'kalender' => array(
                        'kalenderId'=>$tjanstId

                    )
                );
                
                echo json_encode($tabortKalendererrorJson);

               
            }
               
        
        
    $conn->close();
}
function tabortEvent($conn){
    //include('dbh.inc.php');
    if(isset($_POST['id']) ){
        $id = $_POST['id'];
        
    }
    $event = $conn->query('select * from event where id ='.$id);

    $row=$event->fetch_assoc();

    $eventId=$row['id'];

    if($id==$eventId ){
        
        $sql = "DELETE FROM event WHERE id='{$id}'";
        $conn->query($sql);
    }
    else{
        
        include("./json/felhantering.php");
        hantering('400','Event id existerar inte på databasen.',);
    }
    $conn->close();  
}

<?php

// Funktioner för att ta bort

session_start();

include('dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'tabortKalender':
                tabortKalender();
                break;

            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }
$conn->close();




function tabortKalender(){
    include('dbh.inc.php');
    $tjanstId = $_POST['kalenderId'];

        

        
        
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
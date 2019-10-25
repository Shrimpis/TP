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
    $kalenderId = $_POST['kalenderId'];

        

        
        
        $deltjanst = "DELETE FROM tjanst WHERE id = '{$kalenderId}'";
            if(mysqli_query($conn, $deltjanst)){
                $get_result = $conn->query("SELECT * FROM kalender WHERE tjanstId = '{$kalenderId}'");

                while($row=$get_result->fetch_assoc()){
                    $id=$row['id'];
                    $conn->query("DELETE FROM kalendersida WHERE kalenderId = $id");
                }

                

                $sql = "DELETE FROM kalender WHERE tjanstId = '{$kalenderId}'";
                   $conn->query($sql);
                

                $tabortKalenderJson = array(
                    'kod'=> '202',
                    'status'=> 'Accepterad',
                    'meddelande' => 'kalender borttagen',
                    'kalender' => array(
                        'kalenderId'=>$kalenderId

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
                        'kalenderId'=>$kalenderId

                    )
                );
                
                echo json_encode($tabortKalendererrorJson);

               
            }
               
        
        
    $conn->close();
}
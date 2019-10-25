<?php

// Funktioner för att redigera

session_start();

include('./Databas/dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'aktiveraEvent':
                aktiveraEvent($conn);
                break;

            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }


        function aktiveraEvent($conn){
            //-include("../../Databas/dbh.inc.php");
            if(isset($_POST['id']) ){
                $id = $_POST['id'];
            }
            $event = $conn->query('select * from event where id ='.$id);
        
                while($row = $event->fetch_assoc()){
                    $aktiv=$row["aktiv"];
                    if($aktiv==0){
                        $sql= "UPDATE event SET aktiv = '1' WHERE id = $id ";
                        $conn->query($sql);
                        break;
                    }
                    else if($aktiv==1){
                        $sql= "UPDATE event SET aktiv = '0' WHERE id = $id ";
                        $conn->query($sql);
                        echo "blah";
                       break;
                    }

                    else{
                        echo "hej";
                    }
                }
                
                
                   
                    
                
                    
        }
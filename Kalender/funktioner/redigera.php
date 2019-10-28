<?php

// Funktioner för att redigera

session_start();

include('./Databas/dbh.inc.php');
include("./json/felhantering.php");
        switch ($_POST['funktion']) {

            case 'aktiveraEvent':
                aktiveraEvent($conn);
                break;
            case 'redigeraEvent':
                redigeraEvent($conn);
            break;

            default:
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
        }


        function aktiveraEvent($conn){
            
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
                        
                       break;
                    }

                    else{
                        hantering('400','Event id finns inte i database.',);
                        break;
                    }
                }
                
                    
        }

        function redigeraEvent($conn){
            
            if(isset($_POST['id']) && isset($_POST['titel']) && isset($_POST['innehall']) && isset($_POST['startTid']) && isset($_POST['slutTid']) ){
                $id = $_POST['id'];
                $titel = $_POST['titel'];
                $innehall = $_POST['innehall'];
                $startTid = $_POST['startTid'];
                $slutTid = $_POST['slutTid'];
            }
            $event = $conn->query('select * from event where id ='.$id);
        
                while($row = $event->fetch_assoc()){
                    $eventId=$row["id"];
                    if($id==$eventId){
                        
                        $sql= "UPDATE event SET titel='$titel', innehall='$innehall', startTid='$startTid', slutTid='$slutTid' WHERE id =$id ";
                        echo $sql;
                        $conn->query($sql);
                        break;
                    }
                    
                    else{
                        hantering('400','Event id finns inte i database.',);
                        break;
                    }
                }
                
                    
        }
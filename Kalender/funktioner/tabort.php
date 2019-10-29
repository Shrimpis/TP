<?php

// Funktioner för att ta bort

session_start();
include("../../json/felhantering.php");
include('../../Databas/dbh.inc.php');
        switch ($_POST['funktion']) {

            case 'tabortKalender':
                tabortKalender($conn);
                break;
            case 'tabortKalendersida':
                tabortKalendersida($conn);
                break;
            case 'tabortEvent':
                tabortEvent($conn);
                break;
            default:
                hantering('400','ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.',);
                break;

        }






function tabortKalender($conn){
    
    $tjanstId = $_POST['tjanstId'];


        

        
        
        $deltjanst = "DELETE FROM tjanst WHERE id = '{$tjanstId}'";
            if(mysqli_query($conn, $deltjanst)){
                $get_result = $conn->query("SELECT * FROM kalender WHERE tjanstId = '{$tjanstId}'");

                while($row=$get_result->fetch_assoc()){
                    $id=$row['id']; 
                    $get_kalsid = $conn->query("SELECT * FROM kalendersida WHERE kalenderId = $id");
                    while($row = $get_kalsid->fetch_assoc()){
                        $kalsidID = $row['id'];
                        $get_kalevid = $conn->query("SELECT * FROM kalenderevent WHERE kalenderId = $kalsidID");
                     
                        
                        while($row = $get_kalevid->fetch_assoc()){
                            $eventId = $row['eventId'];
                            $conn->query("DELETE FROM event WHERE id = $eventId");
                        }
                        $conn->query("DELETE FROM kalenderevent WHERE kalenderId =$kalsidID");
                        
                    }
                    $conn->query("DELETE FROM kalendersida WHERE kalenderId = $id");
                }

                

                $sql = "DELETE FROM kalender WHERE tjanstId = '{$tjanstId}'";
                $conn->query($sql);
                hantering('202','Tog bort kalender');
            }
            else{
                
                hantering('400','kunde ej exekvera',);

               
            }
               
        
        
    
}
function tabortKalendersida($conn){

            if(isset($_POST['sidId'])){
                $sidId = $_POST['sidId'];  
                      
                $get_kalevid = $conn->query("SELECT * FROM kalenderevent WHERE kalenderId = $sidId");
                
                        
                    while($row = $get_kalevid->fetch_assoc()){
                        $eventId = $row['eventId'];
                        $conn->query("DELETE FROM event WHERE id = $eventId");
                    }
                $conn->query("DELETE FROM kalenderevent WHERE kalenderId =$sidId");
                        
                    
                    
                

                

                $sql = "DELETE FROM kalendersida WHERE id = '{$sidId}'";
                $conn->query($sql);
                hantering('202','Tog bort kalendersida');
            }
            else{
                hantering('400','kunde ej exekvera',);
            }
               
        
        
    
}
function tabortEvent($conn){
    //include('dbh.inc.php');
    if(isset($_POST['id']) ){
        $id = $_POST['id'];

    $sql = "DELETE FROM event WHERE id='{$id}'";

    if(mysqli_query($sql)){
        hantering('202','tog bort event');
        
        
    }
    else{
        
        hantering('400','Event id existerar inte på databasen.',);
    }
    }  
}

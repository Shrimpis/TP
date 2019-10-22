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








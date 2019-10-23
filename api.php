<?php

// Databasanslutning //

$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'the_provider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");


// Början av API //


if(!empty($_GET['nyckel'])){ // Kollar efter om api-nyckeln är tom
    
    $apikey = mysqli_real_escape_string($conn,$_GET['nyckel']);
    $sql = "SELECT nyckel FROM api WHERE nyckel = '$apikey'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1){
        if(!empty($_GET['tjanst'])){ // Kollar efter om tjänst är tom

            switch ($_GET['tjanst']) { // Kollar efter vilken tjänst som anropas
        
                case 'blogg':
                    bloggar();
                    break;
                case 'wiki':
                    wiki();
                    break;
                case 'kalender':
                    kalender();
                    break;
                default:
                    error();
            }
        
        } else {
            $error = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'Tjanst must be defined'
            );
            
            echo json_encode($error);
        }
    } else {
        $error = array(
            'code'=> '401',
            'status'=> 'Unauthorized',
            'msg' => 'Api key is either wrong or does not exist. Contact administrator.'
        );
        
        echo json_encode($error);
    }

} else {
    $error = array(
        'code'=> '400',
        'status'=> 'Bad Request',
        'msg' => 'Api key must be defined'
    );
    
    echo json_encode($error);
}

// Tjänster //

function bloggar(){
    if($_GET['typ']=='JSON'){ // Kollar om typen som anropas är JSON
        include "Blogg/json/bloggjson.php";
    } else {
        if($_GET['typ']=='function'){ // Kollar om typen som anropas är funktion
            
            switch ($_GET['handling']) { // Kollar efter vilken handling som anropas
        
                case 'skapa':
                    include "Blogg/funktioner/skapa.php";
                    break;
                case 'tabort':
                    include "Blogg/funktioner/tabort.php";
                    break;
                case 'redigera':
                    include "Blogg/funktioner/redigera.php";
                    break;
                default:
                    $error = array(
                        'code'=> '400',
                        'status'=> 'Bad Request',
                        'msg' => 'You must define a valid action.',
                    );
                    echo json_encode($error);
            }

        } else {
            $error = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'You must define a valid type.',
            );
            
            echo json_encode($error);
        }
    }
}

function wiki(){
    if($_GET['typ']=='JSON'){ // Kollar om typen som anropas är JSON
        include "Wiki/json/wikijson.php";
    } else {
        if($_GET['typ']=='function'){ // Kollar om typen som anropas är funktion
            
            switch ($_GET['handling']) { // Kollar efter vilken handling som anropas
        
                case 'skapa':
                    include "Wiki/funktioner/skapa.php";
                    break;
                case 'tabort':
                    include "Wiki/funktioner/tabort.php";
                    break;
                case 'redigera':
                    include "Wiki/funktioner/redigera.php";
                    break;
                default:
                    $error = array(
                        'code'=> '400',
                        'status'=> 'Bad Request',
                        'msg' => 'You must define a valid action.',
                    );
                    echo json_encode($error);
            }

        } else {
            $error = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'You must define a valid type.',
            );
            
            echo json_encode($error);
        }
    }
}

function kalender(){
    if($_GET['typ']=='JSON'){ // Kollar om typen som anropas är JSON
        include "Kalender/json/kalenderjson.php";
    } else {
        if($_GET['typ']=='function'){ // Kollar om typen som anropas är funktion
            
            switch ($_GET['handling']) { // Kollar efter vilken handling som anropas
        
                case 'skapa':
                    include "Kalender/funktioner/skapa.php";
                    break;
                case 'tabort':
                    include "Kalender/funktioner/tabort.php";
                    break;
                case 'redigera':
                    include "Kalender/funktioner/redigera.php";
                    break;
                default:
                    $error = array(
                        'code'=> '400',
                        'status'=> 'Bad Request',
                        'msg' => 'You must define a valid action.',
                    );
                    echo json_encode($error);
            }

        } else {
            $error = array(
                'code'=> '400',
                'status'=> 'Bad Request',
                'msg' => 'You must define a valid type.',
            );
            
            echo json_encode($error);
        }
    }
}

function error(){
    $error = array(
        'code'=> '400',
        'status'=> 'Bad Request',
        'msg' => 'Could not execute.',
    );
    
    echo json_encode($error);
}

?>
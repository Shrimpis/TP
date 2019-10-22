<?php

// Datasanslutning //

$dbServername = '10.130.216.101';
$dbUsername = 'TheProvider';
$dbPassword = 'lösenord';
$dbName = 'TheProvider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");


// Början av API //


if(!empty($_GET['key'])){ // Kollar efter api-nyckeln är tom
    
    $apikey = mysqli_real_escape_string($conn,$_POST['key']);
    $sql = "SELECT anamn FROM anvandare WHERE anamn = '{$anamn}' AND losenord = '{$hashed_pass}' AND id='1'";
    
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1){
        if(!empty($_GET['tjanst'])){ // Kollar efter tjänst är tom

            switch ($_GET['tjanst']) { // Kollar efter vilken tjänst som anropas
        
                case 'blogg':
                    blogg();
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
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Api key wrong. Contact administrator.'
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

function blogg(){
    echo "blogg";
}

function wiki(){
    echo "wiki";
}

function kalender(){
    echo "kalender";
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
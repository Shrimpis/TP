<?php 

privatiseraWiki();
function privatiseraWiki(){
    include("dbh.inc.php");
    if(isset($_POST['WikiId'])&&isset($_POST['privat'])){
        $WikiId = $_POST['WikiId'];
        $privat = $_POST['privat'];   
    }

    $result = $conn->query("SELECT * FROM Wiki where id= $WikiId ");
        $row = $result->fetch_assoc();
        $tjanstId = $row['tjanstId'];
        $uppdateraTjanst = "UPDATE tjanst SET privat = '{$privat}' WHERE id = $tjanstId ";
    
    
    
    
    if(mysqli_query($conn, $uppdateraTjanst)){

        $privatiseraTjanstJson = array(
            'code'=> '202',
            'status'=> 'Accepted',
            'msg' => 'tjanst har redigerats',
            'tjanst' => array(
                'WikiId'=>$WikiId,
            )
        );
        
        echo json_encode($privatiseraTjanstJson);
    } else {
        $privatiseraTjanstJsonError = array(
            'code'=> '400',
            'status'=> 'Bad Request',
            'msg' => 'Could not execute',
            'tjanst' => array(
                'WikiId'=>$WikiId,
            )
        );
        
        echo json_encode($privatiseraTjanstJsonError);
    }
    $conn->close();
}
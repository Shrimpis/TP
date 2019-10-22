<?php
$conn=new mysqli("localhost","root","","the_provider");
$conn->set_charset("utf8");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['id']) ){
    $id = $_POST['id'];
    lasaSida($id, $conn);
}


    function lasaSida($id, $conn){
        
        $wikiSida = $conn->query('select * from wikisidor where id ='.$id);
    
            $row = $wikiSida->fetch_assoc();
            $låsa=$row["last"];

            if($låsa==0){
                $sql= "UPDATE wikisidor SET wikisidor.last = '1' WHERE id = $id ";
                $conn->query($sql);

             
               
            }
            else if($låsa==1){
                $sql= "UPDATE wikisidor SET wikisidor.last = '0' WHERE id = $id ";
                $conn->query($sql);

            }
    }

?>
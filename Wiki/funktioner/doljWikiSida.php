<?php
$conn=new mysqli("localhost","root","","the_provider");
$conn->set_charset("utf8");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


    function doljSida($id, $conn){

        if(isset($_POST['id']) ){
            $id = $_POST['id'];
            
            $wikiSida = $conn->query('select * from wikisidor where id ='.$id);
    
            $row = $wikiSida->fetch_assoc();
            $dolj=$row["dolt"];

            if($dolj==0){
                $sql= "UPDATE wikisidor SET dolt = '1' WHERE id = $id ";
                $conn->query($sql);
               
            }
            else if($dolj==1){
                $sql= "UPDATE wikisidor SET dolt = '0' WHERE id = $id ";
                $conn->query($sql);

            }

        }
        
    }

?>
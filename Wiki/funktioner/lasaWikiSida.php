<?php
$conn=new mysqli("localhost","root","","the_provider");
$conn->set_charset("utf8");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

    function lasaSida(){

        include('dbh.inc.php');

        if(isset($_POST['id']) ){
            $id = $_POST['id'];

            $wikiSida = $conn->query('select * from wikisidor where id ='.$id);
    
            $row = $wikiSida->fetch_assoc();
            $lasa=$row["last"];

            if($lasa==0){
                $sql= "UPDATE wikisidor SET wikisidor.last = '1' WHERE id = $id ";
                $conn->query($sql);
               
            }
            else if($lasa==1){
                $sql= "UPDATE wikisidor SET wikisidor.last = '0' WHERE id = $id ";
                $conn->query($sql);

            }

        }

        $conn->close();
        
    }

?>
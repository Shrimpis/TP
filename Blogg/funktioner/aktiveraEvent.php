<?php



function aktiveraEvent($conn){
    //-include("../../Databas/dbh.inc.php");
    if(isset($_POST['id']) ){
        $id = $_POST['id'];
    }
    $event = $conn->query('select * from event where id ='.$id);

        $row = $event->fetch_assoc();
        $aktiv=$row["aktiv"];
        while($aktiv < 2){
           
            if($aktiv==0){
                $sql= "UPDATE event SET aktiv = '1' WHERE id = $id ";
                $conn->query($sql);

            }
            else if($aktiv==1){
                $sql= "UPDATE event SET aktiv = '0' WHERE id = $id ";
                $conn->query($sql);

               
            }
            else{
                echo "hej";
            }
    }

        ?>
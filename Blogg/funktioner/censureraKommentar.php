<?php
    include("dbh.inc.php");

    if(isset($_POST['id']) ){
        $id = $_POST['id'];
        
        censureraKommentar($id,  $conn);
    }
    
    function censureraKommentar($id, $conn){
        $kommentar = $conn->query('select * from kommentar where id ='.$id);

            $row = $kommentar->fetch_assoc();
            $censurerad=$row["censurerad"];
            while($censurerad < 2){
               
                if($censurerad==0){
                    $sql= "UPDATE kommentar SET censurerad = '1' WHERE id = $id ";
                    $conn->query($sql);
                    echo "INFO: Kommentaren är nu public.";
                    break;
                   
                }
                else if($censurerad==1){
                    $sql= "UPDATE kommentar SET censurerad = '0' WHERE id = $id ";
                    $conn->query($sql);
                    echo "INFO: Kommentaren är nu privat.";
                   break;
                }
                else{
                    echo "ERROR: kommentar typ måste vara mellan 0 och 1. " . mysqli_error($conn);
                   break;
                }
            }
            
        
        
    }

    $conn->close();

?>
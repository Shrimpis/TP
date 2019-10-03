<?php

     
        include("dbh.inc.php");

        $blogID= $_GET['bid'];
        $date= date("Y-m-d H:i");
        $title= $_GET['Title'];

        $rubrik= $GET['rubrik'];
        $text= $GET['inlagg'];
      
        $sql= "INSERT INTO blogginlagg(BID, datum, title) VALUES ('$blogID','$date','$title')";
        $conn->query($sql);

        $sql1= "INSERT INTO textruta(text, rubrik, title) VALUES ('$blogID','$date','$title')";
        $conn->query($sql1);

        if(mysqli_query($conn, $sql)){
                echo "INFO: Inlägget är nu inlagt.";
            } else {
                echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
        }
?>
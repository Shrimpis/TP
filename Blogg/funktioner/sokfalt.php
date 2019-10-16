<?php

include("dbh.inc.php");


        if(isset($_POST['sok'])){
          
            $sok= $_POST['sok'];

            sokFalt($sok, $conn);
        } 
        //här söker man för bloggInlägg i database.
        function sokFalt($sok, $conn){
            $output = '';

            $query = mysqli_query($conn,"SELECT * FROM blogginlagg WHERE titel LIKE '%$sok%'") or die ("Could not search");
            $count = mysqli_num_rows($query);

            if($count == 0){
                $output = "There was no search results!";
            }
            else{
               while ($row = mysqli_fetch_array($query)) {
                    $title = $row ['titel'];
                    
                    $output ='<div> '.$title.'</div>';
                    print ($output);
                }
            }
        }


?>
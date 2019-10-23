<?php

$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'the_provider';

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
mysqli_set_charset($conn, "utf8mb4");

//här söker man för bloggInlägg i database.
function sokFalt(){

    include('dbh.inc.php');

    if(isset($_POST['sok'])){
          
        $sok= $_POST['sok'];
    
        $query = mysqli_query($conn,"SELECT * FROM wikisidor WHERE titel LIKE '%$sok%'") or die ("Could not search");
        if($count = mysqli_num_rows($query)){
    
    
    
        }else if($count == 0){
            $output = "There was no search results!";
        }

    } 

    $conn->close();

}


?>
<?php
    include('dbh.inc.php');
    $BID = mysqli_real_escape_string($conn, $_REQUEST['BID']);
    $sql = "DELETE FROM blogg WHERE BID='{$BID}'";
    $sql2 = "DELETE FROM blogginlagg WHERE BID='{$BID}'";

    $IIDarray = ($conn->query("SELECT IID from blogginlagg where BID ='{$BID}'"));
    
    while($row = $IIDarray->fetch_assoc()){
        
        
        $IID= $row['IID'];
        
        $sql3="DELETE FROM textruta WHERE IID=$IID";
        $sql4="DELETE FROM rutor WHERE IID=$IID";
        $sql5="DELETE FROM kommentar WHERE IID=$IID";
        
        $conn->query($sql3);
        $conn->query($sql4);
        $conn->query($sql5);
        
    }
    if(mysqli_query($conn, $sql)&&mysqli_query($conn, $sql2)){
        echo "INFO: Blogg borttagen";
    } else {
        echo "ERROR: Could not execute $sql,$sql2. " . mysqli_error($conn);
    }
?>
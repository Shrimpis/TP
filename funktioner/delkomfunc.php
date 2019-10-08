<?php
    include('dbh.inc.php');
    $KID = mysqli_real_escape_string($conn, $_REQUEST['KID']);
    $KIDarray[0] = $KID;
    $temparray = array();
    
    $KIDarray = loop($KID,$conn,$KIDarray,$temparray);
    function loop($KID,$conn,$KIDarray,$temparray){
        if(count($temparray) > 0 ){
            for($i=0;$i<count($temparray);$i++){
            array_push($KIDarray,$temparray[$i]);
            }
            
        }

    $looparray = ($conn->query("SELECT KID from kommentar where HierarchyID ='{$KID}'"));
    
    $temparray = array();
    if(mysqli_num_rows($looparray) > 0)
        while($row=$looparray->fetch_assoc()){
        
        
            array_push($temparray,$row['KID']);
        
        
        
        
        
        }

        if(count($temparray)>0){
            
            return loop($temparray[0],$conn,$KIDarray,$temparray);
        }
    
    


        
    
    

        
        return $KIDarray;  
    }
    var_dump($KIDarray);
    echo "<br>";
    
    $deleteID = implode(',',$KIDarray);
    
    $sql = "DELETE FROM kommentar WHERE KID in ($deleteID)";
    
    if(mysqli_query($conn, $sql)){
        echo "INFO: kommentar borttaget";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
    
?>
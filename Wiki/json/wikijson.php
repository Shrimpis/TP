<?php
    
    $db=new mysqli("localhost","root","","the_provider");
    $db->set_charset("utf8");
    
    if($db->connect_error){
        die("Connection failed: " . $db->connect_error);
    }
    
    /*if(isset($_SESSION["licens"]) && isset($_UID["anvandare"])){
        
        $sql = "SELECT *FROM LICENS WHERE ID =".$_UID["anvandare"];
        $result = $db->query($sql);
        $result = mysqli_fetch_assoc($result);
                
        if($_SESSION["licens"] ==  $result["licens"]){
            
        }else{
            echo "Felaktig/gammal licens. kontakta en adminstratör";
        }
        
    }else{
        echo "Ingen licens. Kontakta adminstratör";
    }*/


    if(isset($_GET['anvandare'])){
        wiki($_GET['anvandare'],$db);
    }


    function wiki($anvandarId,$db){
        $tjanst = $db->query('select * from tjanst where anvandarId='.$anvandarId);
        $wiki = $db->query('select * from wiki');

        $tjanstArray;
        $i=0;
        while($row=$tjanst->fetch_assoc()){
            $tjanstId;
            $flaggad;
            while($row1=$wiki->fetch_assoc()){
                $tjanstId=$row1['tjanstId'];
            }
            if($tjanstId==$row['id']){
                $tjanstArray[$i]=array('titel'=>$row['titel'],'privat'=>$row['privat']);
            }
            $i++;
        }
        

        












        echo '<pre>';
        var_dump($tjanstArray);
        echo '</pre>';
        
    }






?>



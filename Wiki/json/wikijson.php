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
    else if(isset($_GET['anvandare']) && isset($_GET['s'])){
        wiki($_GET['anvandare'],$db);
    }


    function wiki($anvandarId,$db){
        $tjanst = $db->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $db->query('select * from anvandare where id='.$anvandarId);
        $wiki = $db->query('select * from wiki');

        $tjanstArray;
        $i=0;
        while($row=$tjanst->fetch_assoc()){
            $wikiId;
            $tjanstId;//id på tjänsten
            $anamn;//användarnamn
            while($row1=$wiki->fetch_assoc()){
                $tjanstId=$row1['tjanstId'];
                $wikiId=$row1['id'];
            }
            while($row3=$anvandare->fetch_assoc()){
                $anamn=$row3['anamn'];
            }
            if($tjanstId==$row['id']){
                $tjanstArray['wiki']=array('titel'=>$row['titel'],'privat'=>$row['privat'],'anvandarnamn'=>$anamn);
                $wikisidor = $db->query('select * from wikisidor where wikiId='.$wikiId);
                $id=0;
                while($row4=$wikisidor->fetch_assoc()){
                    $tjanstArray['wiki']['sidor'][$id]=array('id'=>$row4['id'],'godkantAv'=>$row4['godkantAv'],'bidragsgivare'=>$row4['bidragsgivare'],'titel'=>$row4['titel'],'innehall'=>$row4['innehall'],$row4['datum']);
                    $id++;
                }

            }
            $i++;
        }
        


        $json=json_encode($tjanstArray);
        echo $json;
        
    }






?>



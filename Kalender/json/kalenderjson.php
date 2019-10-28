<?php
    include("../../json/felhantering.php");
    include("../../Databas/dbh.inc.php");



    //$conn=new mysqli("localhost","root","","the_provider");
   // $conn->set_charset("utf8");
    
   /* if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }*/
    
    /*if(isset($_SESSION["licens"]) && isset($_UID["anvandare"])){
        
        $sql = "SELECT *FROM LICENS WHERE ID =".$_UID["anvandare"];
        $result = $conn->query($sql);
        $result = mysqli_fetch_assoc($result);
                
        if($_SESSION["licens"] ==  $result["licens"]){
            
        }else{
            echo "Felaktig/gammal licens. kontakta en adminstratör";
        }
        
    }else{
        echo "Ingen licens. Kontakta adminstratör";
    }*/


   
    if(isset($_GET['anvandare']) && isset($_GET['kalenderSida'])){
        kalender($_GET['anvandare'],$_GET['kalenderSida'],$conn);
    }
    else if(isset($_GET['anvandare'])){
        kalenders($_GET['anvandare'],$conn);
    }
    else{
        hantering('400','inga post variabler är satta.',);
    }

    function kalender($anvandarId,$kalenderSidaId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        //$kalender = $conn->query('select * from kalender where id='.$kalenderId);

        $tjanstArray=array();
        $kalenderSida = $conn->query('select * from kalendersida where id='.$kalenderSidaId);
        while($row=$kalenderSida->fetch_assoc()){
            //$tjanstArray=array('anvandarId'=>$row['anvandarId']);

            $kalenderevent = $conn->query('select * from kalenderevent where kalenderId='.$kalenderSidaId);
            $eventIds=array();
            $i=0;
            while($row=$kalenderevent->fetch_assoc()){
                if($row['status']=='1'){
                    $eventIds[$i]=$row['eventId'];
                    $i++;
                }
            }
        }


        $ii=0;
        $events = $conn->query('select * from event');
        while($row=$events->fetch_assoc()){
            for($i=0;$i<count($eventIds);$i++){
                if($eventIds[$i]==$row['id']){
                    $tjanstArray['event'][$ii]=array('id'=>$row['id'],'skapadAv'=>$row['skapadAv'],'titel'=>$row['titel'],'innehall'=>$row['innehall'],'startTid'=>$row['startTid'],'slutTid'=>$row['slutTid'],'aktiv'=>'aktiv');
                    $ii++;
                }
                $i++;
            }
        }



        
        if($tjanstArray==null){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna wiki',);
            return;
        }


        $json=json_encode($tjanstArray);
        echo $json;
        
    }




    /*function kalender($anvandarId,$kalenderId,$kalenderSidaId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $kalender = $conn->query('select * from kalender where id='.$kalenderId);

        $tjanstArray=array();
        while($row=$tjanst->fetch_assoc()){
            $tjanstId;//id på tjänsten
            $anamn;//användarnamn
            while($row1=$kalender->fetch_assoc()){//hittar viken tjänst som sitter ihop med 
                $tjanstId=$row1['tjanstId'];
            }
            while($row3=$anvandare->fetch_assoc()){//hämtar användarnamnet på den som har wikin.
                $anamn=$row3['anamn'];
            }

            if($tjanstId==$row['id']){//om kalendern finns i tjänsten.
                $tjanstArray=array('titel'=>$row['titel'],'privat'=>$row['privat'],'anvandarnamn'=>$anamn);// hämtar wikin från tjänsten.
                $kalender = $conn->query('select * from kalender where id='.$kalenderId);
                $id=0;
                
                
                while($row4=$kalender->fetch_assoc()){//håämtar saker från alla kalender.
                    $kalenderSida = $conn->query('select * from kalendersida where id='.$kalenderSidaId);
                    while($row5=$kalenderSida->fetch_assoc()){

                    }


                    $id++;
                }

            }

        }
        
        if($tjanstArray==null){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna wiki',);
            return;
        }


        $json=json_encode($tjanstArray);
        echo $json;
        
    }*/




    function kalenders($anvandarId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $wiki = $conn->query('select * from wiki');

        $tjanstArray;
        $i=0;
        while($row=$tjanst->fetch_assoc()){
            $kalenderId;
            $tjanstId;//id på tjänsten
            
            $wiki = $conn->query('select * from wiki');//inte bra preformance fixa?????
            while($row1=$wiki->fetch_assoc()){//hittar vika tjänster som sitter ihop med wikis
                //$tjanstId=$row1['tjanstId'];
                $kalenderId=$row1['id'];

                
               
                if($row1['tjanstId']==$row['id']){//om wikin finns i tjänsten.
                    $tjanstArray['wiki'][$i]=array('titel'=>$row['titel'],'privat'=>$row['privat']);// hämtar wikin från tjänsten.
                    $kalender = $conn->query('select * from kalender where kalenderId='.$kalenderId);
                    $id=0;
                    
                    
                    while($row4=$kalender->fetch_assoc()){//hämtar saker från alla kalender.
                        $tjanstArray['wiki'][$i]['sidor'][$id]=array('id'=>$row4['id']);
                        
                        $id++;
                    }
                    

                    $i++;
                }
            }
            

        }

        $anamn;//användarnamn
        while($row3=$anvandare->fetch_assoc()){//hämtar användarnamnet på den som har wikin.
            $anamn=$row3['anamn'];
        }
        
        $tjanstArray['anvandarnamn']=$anamn;

        $json=json_encode($tjanstArray);
        echo $json;
        
    }






?>
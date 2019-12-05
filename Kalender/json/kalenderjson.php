<?php
    include("../../json/felhantering.php");
    include("../../Databas/dbh.inc.php");
    include("../../api_anvandare.php");




    if(isset($_POST['kalenderSida'])){
        kalenderJson(getAnvandare($conn),$_POST['kalenderSida'],$conn);
    }
    else if(isset($_POST['kalender'])){
        kalenders(getAnvandare($conn),$_POST['kalender'],$conn);
    }
    else{
        allaKalendrar(getAnvandare($conn),$conn);
    }




    function allaKalendrar($anvandarId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        echo $tjanst;
        $i=0;
        $kalenderArray;
        //while($row=$tjanst->fetch_assoc()){
            $kalender = $conn->query('select * from kalender where tjanstId='.$row['id']);
            if($kalender->num_rows==1){
                $row1=$kalender->fetch_assoc();

                $kalenderArray[$i]=array('id'=>$row1['id'],'titel'=>$row['titel'],'privat'=>$row['privat']);
                $i++;
            }
        //}

        $json=json_encode($kalenderArray);
        echo $json;
    }





    function kalenderJson($anvandarId,$kalenderSidaId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        //$kalender = $conn->query('select * from kalender where id='.$kalenderId);

        $tjanstArray=array();
        $kalenderSida = $conn->query('select * from kalendersida where id='.$kalenderSidaId);
        while($row=$kalenderSida->fetch_assoc()){

            $anamn;
            while($namn=$anvandare->fetch_assoc()){
                $anamn=$namn['anamn'];
            }

            $tjanstArray=array('anamn'=>$anamn);

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

        if(!isset($eventIds)){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna wiki');
            return;
        }


        $ii=0;
        $events = $conn->query('select * from event');
        while($row=$events->fetch_assoc()){
            for($i=0;$i<count($eventIds);$i++){
                if($eventIds[$i]==$row['id']){


                    $anvandare = $conn->query('select * from anvandare where id='.$row['skapadAv']);
                    $anamn;
                    while($namn=$anvandare->fetch_assoc()){
                        $anamn=$namn['anamn'];
                    }


                    $tjanstArray['event'][$ii]=array('id'=>$row['id'],'skapadAv'=>$anamn,'titel'=>$row['titel'],'innehall'=>$row['innehall'],'startTid'=>$row['startTid'],'slutTid'=>$row['slutTid'],'aktiv'=>$row['aktiv']);
                    $ii++;
                }
            }
        }




        if($tjanstArray==null){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna kalender');
            return;
        }


        $json=json_encode($tjanstArray);
        echo $json;

    }






    function kalenders($anvandarId,$kalenderId,$conn){
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
                //$kalenderSidor = $conn->query('select * from kalender where id='.$kalender);


                    $kalenderSida = $conn->query('select * from kalendersida where kalenderId='.$kalenderId);
                    $i=0;
                    while($row5=$kalenderSida->fetch_assoc()){


                        $anvandare = $conn->query('select * from anvandare where id='.$row5['anvandarId']);
                        $anamn;
                        while($namn=$anvandare->fetch_assoc()){
                            $anamn=$namn['anamn'];
                        }


                        $tjanstArray['sidor'][$i]=array('id'=>$row5['id'],'anamn'=>$anamn);
                        $i++;
                    }


            }

        }

        if($tjanstArray==null){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna kalender');
            return;
        }


        $json=json_encode($tjanstArray);
        echo $json;

    }






?>

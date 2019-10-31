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



    if(isset($_POST['anvandare']) && isset($_POST['wiki'])){
        wiki($_POST['anvandare'],$_POST['wiki'],$conn);
    }
    else if(isset($_POST['anvandare'])){
        wikis($_POST['anvandare'],$conn);
    }
    else{
        hantering('400','inga post variabler är satta.');
    }

    function wiki($anvandarId,$wikiId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $wiki = $conn->query('select * from wiki where id='.$wikiId);

        $tjanstArray=array();
        while($row=$tjanst->fetch_assoc()){
            $tjanstId;//id på tjänsten
            $anamn;//användarnamn
            while($row1=$wiki->fetch_assoc()){//hittar viken tjänst som sitter ihop med
                $tjanstId=$row1['tjanstId'];
            }
            while($row3=$anvandare->fetch_assoc()){//hämtar användarnamnet på den som har wikin.
                $anamn=$row3['anamn'];
            }

            if($tjanstId==$row['id']){//om wikin finns i tjänsten.
                $tjanstArray=array('titel'=>$row['titel'],'privat'=>$row['privat'],'anvandarnamn'=>$anamn);// hämtar wikin från tjänsten.
                $wikisidor = $conn->query('select * from wikisidor where wikiId='.$wikiId);
                $id=0;


                while($row4=$wikisidor->fetch_assoc()){//håämtar saker från alla wikisidor.
                    $tjanstArray['sidor'][$id]=array('id'=>$row4['id'],'godkantAv'=>$row4['godkantAv'],'bidragsgivare'=>$row4['bidragsgivare'],'titel'=>$row4['titel'],'innehall'=>$row4['innehall'],'datum'=>$row4['datum'],'dolt'=>$row4['dolt'],'last'=>$row4['last']);

                    $bidragsgivareNamn = $conn->query('select * from anvandare where id='.$row4['bidragsgivare']);
                    while($row5=$bidragsgivareNamn->fetch_assoc()){
                        $tjanstArray['sidor'][$id]['bidragsgivareNamn']=$row5['anamn'];
                    }
                    $godKantAvNamn = $conn->query('select * from anvandare where id='.$row4['godkantAv']);
                    while($row6=$godKantAvNamn->fetch_assoc()){
                        $tjanstArray['sidor'][$id]['godKantAvNamn']=$row6['anamn'];
                    }

                    $id++;
                }

            }

        }

        if($tjanstArray==null){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna wiki');
            return;
        }


        $json=json_encode($tjanstArray);
        echo $json;

    }

    function wikis($anvandarId,$conn){
        $tjanst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $wiki = $conn->query('select * from wiki');

        $tjanstArray;
        $i=0;
        while($row=$tjanst->fetch_assoc()){
            $wikiId;
            $tjanstId;//id på tjänsten

            $wiki = $conn->query('select * from wiki');//inte bra preformance fixa?????
            while($row1=$wiki->fetch_assoc()){//hittar vika tjänster som sitter ihop med wikis
                //$tjanstId=$row1['tjanstId'];
                $wikiId=$row1['id'];



                if($row1['tjanstId']==$row['id']){//om wikin finns i tjänsten.
                    $tjanstArray['wiki'][$i]=array('id'=>$row1['id'],'titel'=>$row['titel'],'privat'=>$row['privat']);// hämtar wikin från tjänsten.
                    $wikisidor = $conn->query('select * from wikisidor where wikiId='.$wikiId);
                    $id=0;


                    while($row4=$wikisidor->fetch_assoc()){//hämtar saker från alla wikisidor.
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

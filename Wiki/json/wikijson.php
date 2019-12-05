<?php

    include("././Databas/dbh.inc.php");
    include("././api_anvandare.php");


    if(isset($_POST['wiki'])){
        wikiJson(getAnvandare($conn),$_POST['wiki'],$conn);
    }
    else if(isset($_POST['sidId'])){
        sidVersion(getAnvandare($conn),$_POST['sidId'],$conn);
    }
    else{
        wikis(getAnvandare($conn),$conn);
    }

    function wikiJson($anvandarId,$wikiId,$conn){
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

    function sidVersion($anvandarId,$sidId,$conn){
        
        
            $sidversion= $conn->query('select * from sidversion where sidId='.$sidId);

            //kollar om användaren äger sidan
            /*$wikisidor= $conn->query('select * from wikisidor where id='.$sidId);
            $row = $wikisidor->fetch_assoc();
            $wikiId=$row['wikiId'];

            $wiki= $conn->query('select * from wiki where id='.$wikiId);
            $row = $wiki->fetch_assoc();
            $tjanstId=$row['tjanstId'];

            $tjanst= $conn->query('select * from tjanst where id='.$tjanstId);
            $row = $tjanst->fetch_assoc();
            $anvandarId2=$row['anvandarId'];

            if($anvandarId!=$anvandarId2){
                hantering('400','något gick fel');
            }*/



        
            $sidVersioner;
            $i=0;

        if($sidversion->fetch_assoc()){
            while($row = $sidversion->fetch_assoc()){
                $sidVersioner[$i]=array('id'=>$row["id"],'sidId' => $row['sidId'],'godkantAv'=>$row["godkantAv"],'bidragsgivare'=>$row["bidragsgivare"],'titel'=>$row["titel"],'innehall'=>$row["innehall"], 'datum'=>$row["datum"]);
                $i++;
            }
        
            $json= json_encode($sidVersioner);
        
            echo $json;
            
        }else{
            $json = json_encode('titel' => 'Hitta ingen historik');

            echo $json;
        }

        /*if(!isset($sidVersioner)){
            hantering('400','fel med hämting av data eller så har du inte åtkomst till denna sidversion');
            return;
        }*/
    
    }






?>

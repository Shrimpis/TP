<?php
    include("./Databas/dbh.inc.php");
    include("././api_anvandare.php");


            if(isset($_POST['blogg']) && isset($_POST['inlagg'])){
                blogginlagg(getAnvandare($conn),$_POST['blogg'],$_POST['inlagg'],$conn);
            }
            else if(isset($_POST['blogg'])){
                blogg(getAnvandare($conn),$_POST['blogg'],$conn);
            }
            else{
                visaBloggar(getAnvandare($conn),$conn);
            }

    

    function blogginlagg($anvandarId,$bloggId,$inlaggId,$conn){
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $blogg = $conn->query('select * from blogg where tjanstId='.$bloggId);
        $blogginlagg = $conn->query('select * from blogginlagg where bloggId='.$bloggId);



        $kommentarArray;//alla kommentarer.

        $blogginlaggArray;//innehåller alla blogginlagg.
        //kollar på alla bloginlagg.
        $i=0;
        while($row = $blogginlagg->fetch_assoc()) {
            $id=$row["id"];//id på det inlagget som vi ar på.
            if($id==$inlaggId){
                $blogginlaggArray=array('id'=>$id,'datum'=>$row["datum"],'titel'=>$row["titel"],'innehall'=>$row["innehall"]);//skappar en array som innehåller datum title



                //lagger in kommentarer.
                $tempKommentar=$conn->query('select * from kommentar inner join anvandare on kommentar.id=anvandare.id where inlaggId='.$id); //hamtar alla kommentarer i ett bloginlagg
                //echo var_dump($tempKommentar);
                $kommentarArray=array();
                $index=0;
                while($row = $tempKommentar->fetch_assoc()) {
                    $kommentarFlaggningar = $conn->query('select * from flaggadkommentar where kommentarId='.$row['id']);//alla flaggningar för kommentarer.
                    $Amount=0;
                    while($flaggadRow = $kommentarFlaggningar->fetch_assoc()) {//hur många flaggningar för kommentaren.
                        $Amount++;
                    }

                    $kommentarArray[$index]=array('id'=>$row['id'],'anvandarId'=>$row['anvandarId'],'namn'=>$row['anamn'],'innehall'=>$row['innehall'],'hierarkiId'=>$row['hierarkiId']);
                    $kommentarArray[$index]['flaggningar']=$Amount;


                    $index++;
                }

                $index=0;
                $kommentarArrayFull=array();
                for($ii=0;$ii<count($kommentarArray);$ii++){
                    if($kommentarArray[$ii]['hierarkiId']==0){
                        $tempKommentarer=$kommentarArray;

                        //lägger kommetarer i kommentarer.
                        $kommentarArrayFull[$index]=$tempKommentarer[$ii];
                        $kommentarArrayFull[$index]['kommentarer']=hämtaKommentarer($tempKommentarer[$ii]['id'],$tempKommentarer);
                        $index++;
                    }
                }


                $blogginlaggArray['kommentarer']=$kommentarArrayFull;//lagger in en array med alla kommentarer i blogginlagget.


                //lagger in gillningar.
                $gillningar = $conn->query('select * from gillningar where inlaggId='.$id);
                $gillningarArray=array();
                $index=0;
                while($row = $gillningar->fetch_assoc()) {
                    $gillningarArray[$index]=array('anvandare'=>$row['id']);//alla gillningar i ett blogginlagg.
                    $index++;
                }
                $blogginlaggArray['gillningar']=$gillningarArray;//lagger in en array med alla gillningar i blogginlagget.


                $i++;

            }
        }

        $ii=0;
        $Bloggarray;//innehåller allt i bloggen.

        if(isset($blogginlaggArray)){
            $Bloggarray['bloggInlagg']=$blogginlaggArray;

            $json=json_encode($blogginlaggArray);
            echo $json;
        }
        else{
            $Bloggarray['bloggInlagg']=array();
            $json=json_encode($blogginlaggArray);
            echo $json;
        }

    }




    function visaBloggar($anvandarId,$conn){
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $tjänst = $conn->query('select * from tjanst where anvandarId='.$anvandarId);

        //$tjänstId = $conn->query('select * from tjanst where id='.$anvandarId);


        $anamn;
        $email;
        $i=0;
        while($row = $anvandare->fetch_assoc()) {//lägger in för och efternamn i 2 variabler
            $anamn=$row["anamn"];
            $email=$row["email"];
            $i++;
        }

        //echo var_dump($anvandareArray[]);
        $tjänstArray;
        $bloggArray;

        $i=0;

        while($rowTjänst = $tjänst->fetch_assoc()) {
            $tjänstId=$rowTjänst['id'];
            $blogg = $conn->query('select * from blogg ');
            while($row = $blogg->fetch_assoc()) {
                $bloggIdBlogg=$row['id'];
                $bloggId=$row['tjanstId'];
                if($bloggId==$tjänstId){
                    $tjänstArray['bloggar'][$i]=array('bloggId'=>$bloggIdBlogg,'id'=>$rowTjänst["id"],'titel'=>$rowTjänst["titel"],'privat'=>$rowTjänst["privat"]);
                    $i++;
                }

            }


           
        }

        $tjänstArray['anamn']=$anamn;//användarnamnanamn
        $tjänstArray['email']=$email;//email


        if(isset($tjänstArray)){
            $json=json_encode($tjänstArray);
            echo $json;
        }

    }

    function visaAnvandare($conn){
        $anvandare = $conn->query('select * from anvandare');

        $anvandareArray;
        $i=0;
        while($row = $anvandare->fetch_assoc()) {
            $anvandareArray['anvandare'][$i]=array('id'=>$row["id"],'anamn'=>$row["anamn"], 'email'=>$row["email"]);
            $i++;
        }



        if(isset($anvandareArray)){
            $json=json_encode($anvandareArray);
            echo $json;
        }


    }


    function hämtaKommentarer($id,$minaKommentarer){
        $index=0;
        $kommentarArrayFull=array();
            for($ii=0;$ii<count($minaKommentarer);$ii++){
                if($minaKommentarer[$ii]['hierarkiId']==$id){
                    $tempKommentarer=$minaKommentarer;

                    $kommentarArrayFull[$index]=$tempKommentarer[$ii];
                    $kommentarArrayFull[$index]['kommentarer']=hämtaKommentarer($minaKommentarer[$ii]['id'],$minaKommentarer);

                    $index++;
                }

            }
            return $kommentarArrayFull;
    }

    function blogg($anvandarId,$bloggId,$conn){
        $anvandare = $conn->query('select * from anvandare where id='.$anvandarId);
        $blogg = $conn->query('select * from blogg where tjanstId='.$bloggId);
        $blogginlagg = $conn->query('select * from blogginlagg where bloggId='.$bloggId);


        $kommentarArray=array();//alla kommentarer.


        $blogginlaggArray;//innehåller alla blogginlagg.
        //kollar på alla bloginlagg.
        $i=0;
        while($row = $blogginlagg->fetch_assoc()) {
            $id=$row["id"];//id på det inlagget som vi ar på.
            $blogginlaggArray[$i]=array('id'=>$id,'datum'=>$row["datum"],'titel'=>$row["titel"]);//skappar en array som innehåller datum title

            $i++;

        }




        $ii=0;
        $Bloggarray;//innehåller allt i bloggen.
        while($row=$blogg->fetch_assoc()){
            //$Bloggarray=array('flaggad'=>$row["flaggad"]);

            $tjanstId=$row['tjanstId'];
            $bloggIdBlogg=$row['id'];
            
            $tjanst = $conn->query('select * from tjanst where id='.$tjanstId.' and anvandarId='.$anvandarId);
            $error=true;
            while($row=$tjanst->fetch_assoc()){
                $Bloggarray['titel']=$row['titel'];
                $Bloggarray['privat']=$row['privat'];
                $bloggArray['bloggId']=$bloggIdBlogg;
                $error=false;
            }
            if($error){
                $json=json_encode("du är inte användare till denna blogg");
                echo $json;
                return;
            }

            $ii++;
        }


        $i=0;
        while($row = $anvandare->fetch_assoc()) {//lägger in för och efternamn i 2 variabler
            $anamn=$row["anamn"];
            $i++;
        }

        $Bloggarray['anamn']=$anamn;//användarnamn


        $bloggFlaggningar = $conn->query('select * from flaggadblogg where bloggId='.$bloggId);
        $bloggFlaggningarAmount=0;
        while($flaggadRow = $bloggFlaggningar->fetch_assoc()) {
            $bloggFlaggningarAmount++;
        }
        $Bloggarray['flaggningar']=$bloggFlaggningarAmount;



        if(isset($blogginlaggArray)){
            $Bloggarray['bloggInlagg']=$blogginlaggArray;

            $json=json_encode($Bloggarray);
            echo $json;
        }


        else{
            $Bloggarray['bloggInlagg']=array();
            $json=json_encode($Bloggarray);
            echo $json;
        }

    }


?>

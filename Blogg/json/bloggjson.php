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

        if(isset($_GET['anvandare']) && isset($_GET['blogg'])){
            blog($_GET['anvandare'],$_GET['blogg'],$db);

        }
        else if(isset($_GET['anvandare']) && isset($_GET['blogg']) && isset($_GET['inlagg']) ){
                bloginlagg($_GET['anvandare'],$_GET['blogg'],$db);

        }
        else if(isset($_GET['anvandare'])){
            visaBloggar($_GET['anvandare'],$db);
        }
        else{
            visaAnvandare($db);
        }
            
        
        function visaBloggar($anvandarId,$db){
            $anvandare = $db->query('select * from anvandare where id='.$anvandarId);
            $blogg = $db->query('select * from blogg where anvandarId='.$anvandarId);


            $fnamn;
            $enamn;
            $i=0;
            while($row = $anvandare->fetch_assoc()) {//lägger in för och efternamn i 2 variabler
                $fnamn=$row["fnamn"];
                $enamn=$row["enamn"];
                $i++;
            }
            
            //echo var_dump($anvandareArray[]);
            $bloggar;
            $i=0;
            while($row = $blogg->fetch_assoc()) {
                $bloggar['bloggar'][$i]=array('titel'=>$row["titel"],'anvandarId'=>$row["anvandarId"]);
                
                $bloggId= $row['id'];
                $bloggInlaggCount = $db->query('SELECT * FROM blogginlagg where bloggId='.$bloggId);
                $count=0;
                while($row = $bloggInlaggCount->fetch_assoc()) {
                    $count++;
                }
                $bloggar['bloggar'][$i]['inlaggMangd']=$count;
               $i++;
            }
            
            $bloggar['fnamn']=$fnamn;//förnamn
            $bloggar['enamn']=$enamn;//efternamn


            if(isset($bloggar)){
                $json=json_encode($bloggar);
                echo $json;
            }


        }

        function visaAnvandare($db){
            $anvandare = $db->query('select * from anvandare');

            $anvandareArray;
            $i=0;
            while($row = $anvandare->fetch_assoc()) {
                $anvandareArray['anvandare'][$i]=array('id'=>$row["id"],'fnamn'=>$row["fnamn"],'enamn'=>$row["enamn"]);
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
                    if($minaKommentarer[$ii]['hierarchyID']==$id){
                        $tempKommentarer=$minaKommentarer;
                        
                        $kommentarArrayFull[$index]=$tempKommentarer[$ii];
                        $kommentarArrayFull[$index]['kommentarer']=hämtaKommentarer($minaKommentarer[$ii]['KID'],$minaKommentarer);

                        $index++;
                    }

                }
                return $kommentarArrayFull;
        }

        function blog($anvandarId,$bloggId,$db){
            $anvandare = $db->query('select * from anvandare where id='.$anvandarId);
            $blogg = $db->query('select * from blogg where tjanstId='.$bloggId);
            $blogginlagg = $db->query('select * from blogginlagg where bloggId='.$bloggId);

            
            


            $kommentarArray=array();//alla kommentarer.


            $blogginlaggArray;//innehåller alla blogginlagg.
            //kollar på alla bloginlagg.
            $i=0;
            while($row = $blogginlagg->fetch_assoc()) {
                $id=$row["id"];//id på det inlagget som vi ar på.
                $blogginlaggArray[$i]=array('id'=>$id,'datum'=>$row["datum"],'titel'=>$row["titel"]);//skappar en array som innehåller datum title


                /*
                //lagger in kommentarer.
                $tempKommentar=$db->query('select * from kommentar inner join anvandare on kommentar.UID=anvandare.UID where IID='.$IID); //hamtar alla kommentarer i ett bloginlagg
                //echo var_dump($tempKommentar);
                $kommentarArray=array();
                $index=0;
                while($row = $tempKommentar->fetch_assoc()) {
                    $kommentarArray[$index]=array('KID'=>$row['KID'],'anvandareID'=>$row['UID'],'namn'=>$row['fnamn'].' '.$row['enamn'],'text'=>$row['text'],'hierarchyID'=>$row['hierarchyID']);
                   
                    $index++;
                }

                $index=0;
                $kommentarArrayFull=array();
                for($ii=0;$ii<count($kommentarArray);$ii++){
                    if($kommentarArray[$ii]['hierarchyID']==0){
                        $tempKommentarer=$kommentarArray;

                        //lägger kommetarer i kommentarer.
                        $kommentarArrayFull[$index]=$tempKommentarer[$ii];
                        $kommentarArrayFull[$index]['kommentarer']=hämtaKommentarer($tempKommentarer[$ii]['KID'],$tempKommentarer);
                        $index++;
                    }
                }



                $blogginlaggArray[$i]['kommentarer']=$kommentarArrayFull;//lagger in en array med alla kommentarer i blogginlagget.




                //lagger in gillningar.
                $gillningar = $db->query('select * from gillningar where IID='.$IID);
                $gillningarArray=array();
                $index=0;
                while($row = $gillningar->fetch_assoc()) {
                    $gillningarArray[$index]=array('anvandare'=>$row['UID']);//alla gillningar i ett blogginlagg.
                    $index++;
                }
                $blogginlaggArray[$i]['gillningar']=$gillningarArray;//lagger in en array med alla gillningar i blogginlagget.



*/

                $i++;


            }








            


            
            

            $ii=0;
            $Bloggarray;//innehåller allt i bloggen.
            while($row=$blogg->fetch_assoc()){
                //$Bloggarray=array('titel'=>$row["titel"]);
                $Bloggarray=array('flaggad'=>$row["flaggad"]);

                $tjanstId=$row['tjanstId'];

                $tjanst = $db->query('select * from tjanst where id='.$tjanstId);
                while($row=$tjanst->fetch_assoc()){
                    $Bloggarray['titel']=$row['titel'];
                    $Bloggarray['privat']=$row['privat'];
                }
                $ii++;
            }






            $fnamn;
            $enamn;
            $i=0;
            while($row = $anvandare->fetch_assoc()) {//lägger in för och efternamn i 2 variabler
                $fnamn=$row["fnamn"];
                $enamn=$row["enamn"];
                $i++;
            }
            
            $Bloggarray['fnamn']=$fnamn;//förnamn
            $Bloggarray['enamn']=$enamn;//efternamn









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



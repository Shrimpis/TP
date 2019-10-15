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
            $blogg = $db->query('select * from blogg where id='.$anvandarId);

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
                $bloggar['bloggar'][$i]=array('titel'=>$row["title"],'id'=>$row["id"]);
                
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
                $anvandareArray['anvandare'][$i]=array('UID'=>$row["UID"],'fnamn'=>$row["fnamn"],'enamn'=>$row["enamn"]);
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
            $anvandare = $db->query('select * from anvandare where UID='.$anvandarId);
            $blogg = $db->query('select * from blogg where BID='.$bloggId);
            $blogginlagg = $db->query('select * from blogginlagg where BID='.$bloggId);


            


            $kommentarArray=array();//alla kommentarer.


            $blogginlaggArray;//innehåller alla blogginlagg.
            //kollar på alla bloginlagg.
            $i=0;
            while($row = $blogginlagg->fetch_assoc()) {
                $IID=$row["IID"];//id på det inlagget som vi ar på.
                $blogginlaggArray[$i]=array('IID'=>$IID,'datum'=>$row["datum"],'titel'=>$row["title"]);//skappar en array som innehåller datum title






                $rutor = $db->query('select * from rutor where IID='.$IID.' order by ordning ASC');
                $textruta = $db->query('select * from textruta where IID='.$IID);
                $bildruta = $db->query('select * from bildruta where IID='.$IID);


                //lagger in rutor.
                $rutorArray=array();
                $index=0;
                while($row = $rutor->fetch_assoc()) {
                    $rutorArray[$index]=array($row['RID'],$row['ordning']);//alla rutor i ett blogginlagg.
                    $index++;
                }
                $textrutaArray=array();
                $index=0;
                while($row = $textruta->fetch_assoc()) {
                    $textrutaArray[$index]=array($row['RID'], $row['rubrik'], $row['text']);//alla textrutor i ett blogginlagg.
                    $index++;
                }
                $bildrutaArray=array();
                $index=0;
                while($row = $bildruta->fetch_assoc()) {
                    $bildrutaArray[$index]=array($row['RID'],$row['bildPath']);//alla bildrutor i ett blogginlagg.
                    $index++;
                }

                $inlaggRutor=array();
                for($in=0;$in<count($rutorArray);$in++){

                    for($ii=0;$ii<count($textrutaArray);$ii++){//går igenom alla textrutor och kollar om dom har samma index som en av rutornas id.
                       
                        if($textrutaArray[$ii][0]==$rutorArray[$in][0]){
                            $inlaggRutor[$in]=array('type'=>'textRuta','rubrik'=>$textrutaArray[$ii][1],'text'=>$textrutaArray[$ii][2],'ordning'=>$rutorArray[$in][1]);//om rutan ar en text så skappa en textruta
                        }
                    }
                    for($ii=0;$ii<count($bildrutaArray);$ii++){//går igenom alla bildrutorna och kollar om dom har samma index som en av rutornas id.
                        if($bildrutaArray[$ii][0]==$rutorArray[$in][0]){
                            $inlaggRutor[$in]=array('type'=>'bildRuta','bild'=>$bildrutaArray[$ii][1],'ordning'=>$rutorArray[$in][1]);//om rutan ar en bild så skappa en bildruta
                        }
                    }
                    
                }
                $blogginlaggArray[$i]['rutor']=$inlaggRutor;//lagger i alla text och bildrutor i blogginlagg.




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

                /*echo '<pre>';
                var_dump($kommentarArray);
                echo '</pre> <br><br>sadsadasdadadsadasdas<br>';*/


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





                $i++;


            }








            


            
            


            $Bloggarray;//innehåller allt i bloggen.
            while($row=$blogg->fetch_assoc()){
                $Bloggarray=array('titel'=>$row["title"]);
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



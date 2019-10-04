    <?php

        $db=new mysqli("localhost","root","","the_provider");
        $db->set_charset("utf8");

        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }

        if(isset($_GET['användare']) && isset($_GET['blogg'])){
                blog($_GET['användare'],$_GET['blogg'],$db);

        }
        else{
            
        }
        

        function blog($anvandarId,$bloggId,$db){
            $anvandare = $db->query('select * from anvandare where UID='.$anvandarId);
            $blogg = $db->query('select * from blogg where BID='.$bloggId);
            $blogginlagg = $db->query('select * from blogginlagg where BID='.$bloggId);


            


            $kommentarArray=array();//alla kommentarer.


            $blogginlaggArray;//innehåller alla blogginlägg.
            //kollar på alla bloginlägg.
            $i=0;
            while($row = $blogginlagg->fetch_assoc()) {
                $IID=$row["IID"];//id på det inlägget som vi är på.
                $blogginlaggArray[$i]=array('datum'=>$row["datum"],'titel'=>$row["title"]);//skappar en array som innehåller datum title






                $rutor = $db->query('select * from rutor where IID='.$IID.' order by ordning ASC');
                $textruta = $db->query('select * from textruta where IID='.$IID);
                $bildruta = $db->query('select * from bildruta where IID='.$IID);


                //lägger in rutor.
                $rutorArray=array();
                $index=0;
                while($row = $rutor->fetch_assoc()) {
                    $rutorArray[$index]=array($row['RID'],$row['ordning']);//alla rutor i ett blogginlägg.
                    $index++;
                }
                $textrutaArray=array();
                $index=0;
                while($row = $textruta->fetch_assoc()) {
                    $textrutaArray[$index]=array($row['RID'], $row['rubrik'], $row['text']);//alla textrutor i ett blogginlägg.
                    $index++;
                }
                $bildrutaArray=array();
                $index=0;
                while($row = $bildruta->fetch_assoc()) {
                    $bildrutaArray[$index]=array($row['RID'],$row['bild']);//alla bildrutor i ett blogginlägg.
                    $index++;
                }

                $inlaggRutor=array();
                for($in=0;$in<count($rutorArray);$in++){

                    for($ii=0;$ii<count($textrutaArray);$ii++){//går igenom alla textrutor och kollar om dom har samma index som en av rutornas id.
                       
                        if($textrutaArray[$ii][0]==$rutorArray[$in][0]){
                            $inlaggRutor[$in]=array('type'=>'textRuta','rubrik'=>$textrutaArray[$ii][1],'text'=>$textrutaArray[$ii][2],'ordning'=>$rutorArray[$in][1]);//om rutan är en text så skappa en textruta
                        }
                    }
                    for($ii=0;$ii<count($bildrutaArray);$ii++){//går igenom alla bildrutorna och kollar om dom har samma index som en av rutornas id.
                        if($bildrutaArray[$ii][0]==$rutorArray[$in][0]){
                            $inlaggRutor[$in]=array('type'=>'bildRuta','bild'=>$bildrutaArray[$ii][1],'ordning'=>$rutorArray[$in][1]);//om rutan är en bild så skappa en bildruta
                        }
                    }
                    
                }
                $blogginlaggArray[$i]['rutor']=$inlaggRutor;//lägger i alla text och bildrutor i blogginlägg.




                //lägger in kommentarer.
                $tempKommentar=$db->query('select * from kommentar where IID='.$IID); //hämtar alla kommentarer i ett bloginlägg
                $kommentarArray;
                $index=0;
                while($row = $tempKommentar->fetch_assoc()) {
                    $kommentarArray[$index]=array('användare'=>$row['UID'],'text'=>$row['text'],'hierarchyID'=>$row['hierarchyID']);
                   
                    $index++;
                }
                $blogginlaggArray[$i]['kommentarer']=$kommentarArray;//lägger in en array med alla kommentarer i blogginlägget.




                //lägger in gillningar.
                $gillningar = $db->query('select * from gillningar where IID='.$IID);
                $gillningarArray=array();
                $index=0;
                while($row = $gillningar->fetch_assoc()) {
                    $gillningarArray[$index]=array('användare'=>$row['UID']);//alla gillningar i ett blogginlägg.
                    $index++;
                }
                $blogginlaggArray[$i]['gillningar']=$gillningarArray;//lägger in en array med alla gillningar i blogginlägget.





                $i++;


            }
            


            $Bloggarray;//innehåller allt i bloggen.
            while($row=$blogg->fetch_assoc()){
                $Bloggarray=array('titel'=>$row["title"]);
            }

            if(isset($blogginlaggArray)){
                $Bloggarray['bloggInlagg']=$blogginlaggArray;
                
                $json=json_encode($Bloggarray);
                echo $json;
            }
            else{
                $json=json_encode("blogginlägg eller blogg är inte set");
                echo $json;
            }


           /* $j = json_decode($json);  
            echo '<pre>';
            var_dump($j);
            echo '</pre>';*/

        }

        

?>



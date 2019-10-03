    <?php

        $db=new mysqli("localhost","root","","the_provider");
        $db->set_charset("utf8");

        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }

        if(isset($_GET['send'])){
            //echo 'send is set. <br> ';

            $send=$_GET['send'];
            if($send=="blogg"){
                blog(1,1,$db);
            }

        }
        else{
            echo 'send not set';
        }
        

        function blog($användarId,$bloggId,$db){
            $användare = $db->query('select * from anvandare where UID='.$användarId);
            $blogg = $db->query('select * from blogg where BID='.$bloggId);
            $blogginlagg = $db->query('select * from blogginlagg where BID='.$bloggId);


            


            $kommentarArray=array();//alla kommentarer.


            $blogginlaggArray;//innehåller alla blogginlägg.
            //kollar på alla bloginlägg.
            $i=0;
            while($row = $blogginlagg->fetch_assoc()) {
                $IID=$row["IID"];//id på det inlägget som vi är på.
                $blogginlaggArray[$i]=array($row["datum"],$row["title"]);//skappar en array som innehåller datum title






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
                            $inlaggRutor[$in]=array('textRuta',$textrutaArray[$ii][1],$textrutaArray[$ii][2],$rutorArray[$in][1]);//om rutan är en text så skappa en textruta
                        }
                    }
                    for($ii=0;$ii<count($bildrutaArray);$ii++){//går igenom alla bildrutorna och kollar om dom har samma index som en av rutornas id.
                        if($bildrutaArray[$ii][0]==$rutorArray[$in][0]){
                            $inlaggRutor[$in]=array('bildRuta',$bildrutaArray[$ii][1],$rutorArray[$in][1]);//om rutan är en bild så skappa en bildruta
                        }
                    }
                    
                }
                $blogginlaggArray[$i][2]=$inlaggRutor;//lägger i alla text och bildrutor i blogginlägg.




                //lägger in kommentarer.
                $tempKommentar=$db->query('select * from kommentar where IID='.$IID); //hämtar alla kommentarer i ett bloginlägg
                $kommentarArray;
                $index=0;
                while($row = $tempKommentar->fetch_assoc()) {
                    $kommentarArray[$index]=array('KID'=>$row['KID'],'UID'=>$row['UID'],'IID'=>$row['IID'],'text'=>$row['text'],'hierarchyID'=>$row['hierarchyID']);
                   
                    $index++;
                }
                $blogginlaggArray[$i][3]=$kommentarArray;//lägger in en array med alla kommentarer i blogginlägget.




                $gillningar = $db->query('select * from gillningar where IID='.$IID);
                $gillningarArray=array();
                $index=0;
                while($row = $gillningar->fetch_assoc()) {
                    $gillningarArray[$index]=array('användare'=>$row['UID']);//alla gillningar i ett blogginlägg.
                    $index++;
                }
                $blogginlaggArray[$i][4]=$gillningarArray;//lägger in en array med alla gillningar i blogginlägget.





                $i++;


            }
            


            $Bloggarray;//innehåller allt i bloggen.
            while($row=$blogg->fetch_assoc()){
                $Bloggarray=array('titel'=>$row["title"]);
            }

            
            $Bloggarray['bloggInlagg']=$blogginlaggArray;

            $json=json_encode($Bloggarray);
            echo $json;



           /* $j = json_decode($json);  
            echo '<pre>';
            var_dump($j);
            echo '</pre>';*/

        }

        

?>



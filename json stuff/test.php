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

            $kommentarer = $db->query('select * from kommentar');
            $kommentarArray=array();


            $blogginlaggArray;
            //kollar på alla bloginlägg.
            $i=0;
            while($row = $blogginlagg->fetch_assoc()) {
                $IID=$row["IID"];
                $blogginlaggArray[$i]=array($row["datum"],$row["title"],array());

                $tempKommentar=$db->query('select * from kommentar where IID='.$IID); //hämtar alla komentarer i ett bloginlägg

                $kommentarArray;
                $index=0;
                while($row = $tempKommentar->fetch_assoc()) {
                    $kommentarArray[$index]=array('KID'=>$row['KID'],'UID'=>$row['UID'],'IID'=>$row['IID'],'text'=>$row['text'],'hierarchyID'=>$row['hierarchyID']);
                   
                   // echo $kommentarArray[$index]["text"].'  <br>';
                    $index++;
                }
                $blogginlaggArray[$i][2]=$kommentarArray;
                $i++;


            }
            
           
           /* echo '<pre>';
            var_dump($blogginlaggArray);
            echo '</pre>';*/
            $array;
            while($row=$blogg->fetch_assoc()){
                $array=array($row["title"]);
            }
            
            $index=0;

            //var_dump($blogginlagg);
            
           /* while($row=$blogginlagg->fetch_assoc()){
              
                $array[0][1][$index]=array($row["title"],$row["datum"]);
                $index++;
            }*/
            
            $array[1]=$blogginlaggArray;

            $json=json_encode($array);
            echo $json;

            /*$array=array('sak1','sak2');
            $json=json_encode($array);
            echo $json;*/


           /* $j = json_decode($json);  
            echo '<pre>';
            var_dump($j);
            echo '</pre>';*/

        }

        

?>



<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
    <?php

        $db=new mysqli("localhost","root","","the_provider");

        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }

        if(isset($_GET['send'])){
            echo 'send is set. <br> ';

            $send=$_GET['send'];
            if($send=="blog"){
                blog(1,$db);
            }

        }
        else{
            echo 'send not set';
        }
        

        function blog($användarId,$bloggId,$db){
            $användare = $db->query('select * from anvandare where UID='.$användarId);
            $blogg = $db->query('select * from blogg where BID='.$bloggId);
            $blogginlagg = $db->query('select * from blogginlagg where BID='.$bloggId);
            $kommentarer = $db->query('select * from kommentar where IID='.$bloggId);
            
            



            /*while($row = $blogg->fetch_assoc()) {
                echo $row["UID"];
            }*/



        }

        

?>
    <div id="body" class="container"></div>
        <script>

        </script>
    </body>
</html>



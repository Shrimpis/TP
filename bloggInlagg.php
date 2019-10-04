<?php

        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "the_provider";

        $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db);

        if(isset($_GET['BID']) && isset($_GET['Title'])){
            $blogID= $_GET['BID'];
            $title= $_GET['Title'];

            bloggInlägg($blogID, $title, $conn);
        }

        function bloggInlägg($blogID, $title, $conn){
            $date= date("Y-m-d H:i");

            $sql= "INSERT INTO blogginlagg(BID, datum, title) VALUES ('$blogID','$date','$title')";
            $conn->query($sql);

        //     if(mysqli_query($conn, $sql)){
        //         echo "INFO: Inlägget är nu inlagt.";
        //     } else {
        //         echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
        // }
        }


        //här så addar man texten från URL
        if(isset($_GET['text']) && isset($_GET['rubrik']) && isset($_GET['inlaggID']) && isset($_GET['ordning'])){
            $text= $_GET['text'];
            $rubrik= $_GET['rubrik'];
            $IID= $_GET['inlaggID'];
            $ordning= $_GET['ordning'];

            textRuta($text, $rubrik, $IID, $ordning, $conn);
        }
        
        //här addar man en text till database till en ny ruta som skapas.
        function textRuta($text, $rubrik, $IID, $ordning, $conn){

            $sql= "INSERT INTO rutor(ordning, IID) VALUES ('$ordning','$IID')";
            $conn->query($sql);


            $rutaID= mysqli_insert_id($conn);

            $sql= "INSERT INTO textruta(RID, text, rubrik, IID) VALUES ('$rutaID','$text','$rubrik','$IID')";
            $conn->query($sql);
        }


        //här så addar man bilden från URL
        if(isset($_GET['bild']) && isset($_GET['inlaggID'])&& isset($_GET['ordning'])){
            $bild= $_GET['bild'];
            $IID= $_GET['inlaggID'];
            $ordning= $_GET['ordning'];

            bildRuta($bild, $IID, $ordning, $conn);
        }


        //här addar man en bild till database till en ny ruta som skapas.
        function bildRuta($bild, $IID, $ordning, $conn){

            $sql= "INSERT INTO rutor(ordning, IID) VALUES ('$ordning','$IID')";
            $conn->query($sql);


            $rutaID= mysqli_insert_id($conn);

            $sql= "INSERT INTO bildruta(RID, bild, IID) VALUES ('$rutaID','$bild','$IID')";
            $conn->query($sql);
        }


    ?>
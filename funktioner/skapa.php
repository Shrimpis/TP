<?php

    function skapaBlogg(){

        include("dbh.inc.php");

        $usrid = $_GET['UID'];
        $title = $_GET['Titel'];
        $sql = "INSERT into blogg(title,UID) VALUES('{$title}',$usrid)";
        echo $sql;
        $conn->query($sql);
        $conn->close();

    }

    function skapaInlagg(){



    }

    function skapaTextRuta(){



    }

    function skapaBildRuta(){



    }

    function skapaKommentar(){

        include('dbh.inc.php');
        $UID = mysqli_real_escape_string($conn, $_REQUEST['UID']); //Användar-ID
        $IID = mysqli_real_escape_string($conn, $_REQUEST['IID']); //Blogginlägg-ID
        $text = mysqli_real_escape_string($conn, $_REQUEST['text']); //Kommentar text
        $hierarchyID = mysqli_real_escape_string($conn, $_REQUEST['hierarchyID']);

        $sql = "INSERT INTO kommentar (UID, IID, text, hierarchyID) VALUES ('$UID', '$IID', '{$text}', '$hierarchyID')";
        if(mysqli_query($conn, $sql)){
            echo "INFO: Kommentar skapad.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        $conn->close();

    }

    function sattaOrdning(){

        

    }

    function gillaInlagg(){

        include('dbh.inc.php');
        $UID = mysqli_real_escape_string($conn, $_REQUEST['UID']); //Användar-ID
        $IID = mysqli_real_escape_string($conn, $_REQUEST['IID']); //Blogginlägg-ID

        $redan_gillat = mysqli_query($conn, "SELECT UID, IID FROM gillningar WHERE UID='$UID' AND IID='$IID'");

        if($redan_gillat->num_rows == 0){
            $sql = "INSERT INTO gillningar (UID, IID) VALUES ('$UID', '{$IID}')";
            if(mysqli_query($conn, $sql)){
                echo "INFO: Inlägg med id " .$IID. " gillat av användar med id " .$UID. ".";
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
        } else {
            $sql2 = "DELETE FROM gillningar WHERE UID='$UID' AND IID='$IID'";
            if(mysqli_query($conn, $sql2)){
                echo "ERROR: Användaren har redan gillat. Tar bort gillning.";
            } else{
                echo "ERROR: Could not able to execute $sql2. " . mysqli_error($conn);
            }
        }

        header("location: ../index.php");
        $conn->close();

    }

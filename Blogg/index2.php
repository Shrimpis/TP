<?php 
    include("funktioner/dbh.inc.php");
    
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Provider - Blogg</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"></script>
        <script src="js/visaBlogg.js"></script>
        <script src="js/skapa.js"></script>
    </head>
    <body onload="init()">
    <div class="container">
        <h2>The Provider</h2>
        <p>Blogg Funktioner</p>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="blogg-tab" data-toggle="tab" href="#blogg" role="tab" aria-controls="blogg" aria-selected="true">Blogg</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="visa-blogg-tab" data-toggle="tab" href="#visa-blogg" role="tab" aria-controls="visa-blogg" aria-selected="false">Visa Blogg</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="inlagg-tab" data-toggle="tab" href="#inlagg" role="tab" aria-controls="inlagg" aria-selected="false">Inlägg</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="kommentar-tab" data-toggle="tab" href="#kommentar" role="tab" aria-controls="kommentar" aria-selected="false">Kommentar</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active" id="blogg" role="tabpanel" aria-labelledby="blogg-tab">
                <?php 
                    include "includes/blogg.php";
                ?>
            </div>

            <div class="tab-pane fade" id="visa-blogg" role="tabpanel" aria-labelledby="visa-blogg-tab">
                <?php 
                    include "includes/visa-blogg.php";
                ?>
            </div>
            
            <div class="tab-pane fade" id="inlagg" role="tabpanel" aria-labelledby="inlagg-tab">
                <?php 
                    include "includes/inlagg.php";
                ?>
            </div>
            
            <div class="tab-pane fade" id="kommentar" role="tabpanel" aria-labelledby="kommentar-tab">
                <?php 
                    include "includes/kommentar.php";
                ?>
            </div>
        </div>

    </body>
    <script>
        var simplemde = new SimpleMDE({ element: document.getElementById("inlaggtext") });
        var simplemde = new SimpleMDE({ element: document.getElementById("kommentartext") });
    </script>
</html>
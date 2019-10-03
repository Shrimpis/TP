<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Provider - Ta bort blogg</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <p>Ta bort en blogg</p>
        <form action="tabortblogg.php">
        Välj en blogg:
            <select name="BID" id="BID">
                <?php 
                    include('dbh.inc.php');
                    $sql = "SELECT BID"
                ?>
            </select>
        
        </form>
    </body>
</html>
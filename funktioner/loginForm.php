<!DOCTYPE html>
<?php

    $db = mysqli_connect("localhost","root","","the_provider");
    
    $sql = "SELECT * FROM anvandare";
    
    $result = $db->query($sql);
    
?>



<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="loginAuth.php">
            <select name="anvandare">
                <?php
                    $row = mysqli_fetch_all($result);

                    foreach ($row as $value) {
                        echo "<option value=" . $value[0] . ">" . $value[1] . "</option>";
                    }
                ?>
            </select>
            <input type="submit">
        </form>
    </body>
</html>

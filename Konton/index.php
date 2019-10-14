<!-- Konton -->
<div id="Konton" class="tab-pane fade in active">
                <h3>Konton</h3>
                <br>
                <!-- Skapa Konton -->

            <h4>Skapa ett konto:</h4>
                <!-- <form action="funktioner/skapaKonto.php" method="get"> -->
                <form action="funktioner/skapa.php" method="POST">
                <input type='hidden' name='funktion' value='skapaKonto'/>
                username:<input type="text" name="uname">
                <br><br>
                
                <input type="submit" value="Skapa Konto">
                </form>
                <br><br>
                
</div>
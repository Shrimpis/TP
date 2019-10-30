<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="bloggContainer" class="bloggContainer">
        <div id="headerContainer" class="headerContainer"></div>
        <br><br>
            <div id="skribentContainer" class="skribentContainer"></div>
                <div id="flaggaContainer" class="flaggaContainer"></div>
                <br><br>
                    <div id="bloggInlaggContainer" class="bloggInlaggContainer"></div>
        
    </div>
</body>


<script>

    let anvandarId = <?php echo $_GET['anvandarId']?>;
    let bloggId = <?php echo $_GET['bloggId']?>;
    console.log(bloggId);
    

</script>

<script src="../js/visaBlogg.js"></script>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="kalenderContainer" class="kalenderContainer">
        <div id="titelContainer" class="titelContainer"></div>
        <div id="agareContainer" class="agareContainer"></div>
        <br><br>
        <div id="eventContainer" class="eventContainer"></div>
    </div>    
    
</body>

<script>

    let anvandarId = <?php echo $_GET['anvandarId'] ?>;
    let kalenderId = <?php echo $_GET['kalenderId'] ?>;
    let sidId = <?php echo $_GET['sidId'] ?>;

</script>


<script src="../js/visaKalender.js"></script>
</html>
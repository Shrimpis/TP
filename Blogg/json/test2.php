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
    <body onload="init()">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <script>
        
            function init(){
                var xhttp = new XMLHttpRequest();

                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json=JSON.parse(this.responseText);
                    console.log(json);
                }
                };
                xhttp.open("post", "http://10.130.216.101/TP/api.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("nyckel=JIOAJWWNPA259FB2&tjanst=blogg&typ=JSON&blogg=6");//anvandare=1&blogg=1
            }

        
        </script>
    </body>
</html>
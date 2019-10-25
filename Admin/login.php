<?php 
    include("../Databas/dbh.inc.php");
    session_start();
   
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $anamn = mysqli_real_escape_string($conn,$_POST['anamn']);
        $losenord = mysqli_real_escape_string($conn,$_POST['losenord']);
        echo $anamn . " : ". $losenord;
      
        $Blowfish_Pre = '$2a$10$';
        $Blowfish_End = '$';
        $hashed_pass = crypt($losenord, $Blowfish_Pre . $salt . $Blowfish_End);
      
        $sql = "SELECT anamn FROM anvandare WHERE anamn = '{$anamn}' AND losenord = '{$losenord}' AND id='1'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
        $count = mysqli_num_rows($result);
      
		
        if($count == 1) {
            $_SESSION['login_user'] = $anamn;
            header("location: index.php?userLogin=Success");
        }else {
            $error = "Failed to login.";
            header("location: ./login.php?userLogin=Error?reason=NotAdmin");
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php include 'includes/settings.php'; echo $site_title ?> - Logga in</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action = "" method = "post">
      <h1 class="h3 mb-3 font-weight-normal">Logga in till Kontrollpanelen</h1>
      <?php include 'includes/alert.php' ?>
      <input type="text" id="anamn" name="anamn" class="form-control" placeholder="Användarnamn" required autofocus>
      <br>
      <input type="password" id="losenord" name="losenord" class="form-control" placeholder="Lösenord" required autofocus>
      <br>
      <button class="btn btn-lg btn-primary btn-block" type="submit" value="Submit">Logga in</button>
      <p class="mt-5 mb-3 text-muted"><?php include ('includes/settings.php'); echo $site_footer?></p>
    </form>
  </body>
</html>
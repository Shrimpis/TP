<?php 

session_start();
include("dbh.inc.php");
        switch ($_POST['funktion']) {
            case 'skapaKonto':
                skapaKonto();
                break;
            case 'skapaAKonto':
                skapaAKonto();
                break;

            default:    
                echo "ERROR: Något fel med URL-parametrarna för din begäran. Kontrollera dokumentationen.";
                break;
        }
    
 
$conn->close();

function slumplosen($len) {
    $karaktr = '?$£@!#%&0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $karaktrlen = strlen($karaktr);
    $slumpstr = '';
    for ($i = 0; $i < $len; $i++) {
        $slumpstr .= $karaktr[rand(0, $karaktrlen - 1)];
    }
    return $slumpstr;
}

function skapaKonto(){
    include("dbh.inc.php");
    $uname_tagen=false;
    if(isset($_POST['anamn'])&&isset($_POST['rollid'])&&isset($_POST['id'])){
        $username = $_POST['anamn'];
        $rollid = $_POST['rollid'];
        $id = $_POST['id'];
    }
    $password = slumplosen(10);
    
    $sqlcheck = ($conn->query("SELECT anamn from anvandare"));
    while($row=$sqlcheck->fetch_assoc()){
        if($username==$row['anamn']){
            $uname_tagen=true;
        }
    }
    if($uname_tagen==false){
        $sql= "INSERT INTO anvandare(anamn, losenord) VALUES ('$username','$password')";
        $conn->query($sql);
        $result = ($conn->query("SELECT id from anvandare where anamn ='{$username}'"));
        if(mysqli_num_rows($result) > 0){
            while($row=$result->fetch_assoc()){
                $USID=$row['id'];
                $sql2 = ("INSERT INTO anvandarroll(anvandarid,rollid) VALUES ($USID,$rollid)");
                
                $conn->query($sql2);

                
                $anvandare = "SELECT anvandare.id FROM anvandare WHERE anvandare.anamn ='{$username}'";
                $result2 = $conn->query($anvandare);

                while($row2 = $result2->fetch_assoc()) {
                    $sql3 = mysqli_query($conn,"UPDATE `kund` SET `superadmin` = '1', `kontoID` = '". $row2["id"] ."' WHERE `kund`.`id` = $id");
                }

                header('location = ..index?funktion=skapaKonto?status=success');
            }
        }
        
    }
    else{
        header('location = ..index?funktion=skapaKonto?status=error?reason=usernameTaken');
    }
    $conn->close();
    
}



?>
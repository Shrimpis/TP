

function statusAndra(status){

let http = new XMLHttpRequest();

http.onreadystatechange = function ({

  if(this.status = 200 && this.readyState == 4){

    console.log(this.responseText);

  }


http.open("GET","status.php?status="+status,true);
http.send();
});

}

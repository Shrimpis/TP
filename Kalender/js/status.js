

function statusAndra(status,id){
console.log("test");
let http = new XMLHttpRequest();

http.onreadystatechange = function () {

  if(this.status = 200 && this.readyState == 4){

    console.log(this.responseText);

  }


http.open("GET","../funktioner/status.php?status="+status+"&kalenderID="+id,true);
http.send();
};

}

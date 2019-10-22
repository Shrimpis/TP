
let jsonResponse;

function setID(){
    
    let container = document.getElementsByClassName("fa fa-picture-o");
    container[0].setAttribute("id","bildContainer");
    container[0].setAttribute("onclick","");
    console.log(container[0].innerHTML);
    let div = document.createElement("div");
    let input = document.createElement("input");
    input.onchange = function(){
      createPicture();  
    };
    input.setAttribute("id","bildeID");
    input.setAttribute("type","file");
    input.setAttribute("name","test");
    div.appendChild(input);
    container[0].appendChild(div);
    
}

function createPicture(){
    
    let http = new XMLHttpRequest();
    let formData = new FormData();
    let data = document.getElementById("bildeID").files[0];
    formData.append("file",data);
    
    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          
            jsonResponse = this.responseText;
            console.log(jsonResponse);
      }
        
    };
    
    http.open("POST","funktioner/skapaBilder.php",true);
    http.send(formData);
    
}

$(document).ready(function(){
    setID();
});
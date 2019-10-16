
let jsonData;
let kommentarArray = new Array();
let index = 0;

function createBlogg() {

    createTitel();
    createInlagg();
    createSkribent();
    

}


//Dynamisk
function createSkribent() {
    let body = document.getElementById("skribentContainer");
    let element = document.createElement("p");
    let div = document.createElement("div");

    let skribent = document.createTextNode(jsonData.fnamn);
    element.appendChild(skribent);
    div.appendChild(element);
    body.appendChild(div);
}


//Dynamisk
function createTitel() {
    let body = document.getElementById("headerContainer");
    let element = document.createElement("h1");
    let div = document.createElement("div");

    let titel = document.createTextNode(jsonData.titel);
    element.appendChild(titel);
    div.appendChild(element);
    body.appendChild(div);
}


function createInlagg(id) {
    
    let body = document.getElementById("bloggInlaggContainer");
    let inlagg = document.createElement("div");
    console.log(jsonData);
    inlagg.id = "inlagg" + 1;
    
    let divText = document.createElement("div");
    divText.innerHTML = jsonData.innehall;
    inlagg.appendChild(divText);
    
    body.appendChild(inlagg);
}



//Inte dynamisk
function createKommentar(kom) {
    let body = document.getElementById("kommentarContainer");
    let kommentar = document.createElement("div");

   

            let element = document.createElement("div");
            element.id = "kommentar";
            let element2;

            element2 = document.createElement("p");
            element2.innerHTML = kom.namn + ": " + kom.innehall + " : " + kom.hierarkiId;
            element.appendChild(element2);

            kommentar.appendChild(element);
  

    body.appendChild(kommentar);
}


function recurs(kom){
    if (kom instanceof Object) {
        for (let k in kom){
            if (kom.hasOwnProperty("kommentarer")){
                if(k == "kommentarer"){
                    if(kom[k][index].kommentarer.length > 0){
                        for(let i = 0; i < kom[k].length; i++){
                            createKommentar(kom[k][i]);
                        }
                        recurs(kom[k][index]);
                    }else{
                        createKommentar(kom[k][index]);
                        index++;
                        recurs(kom[k]);
                    }
                
                }
            }                
        }
    }
}



function init() {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            
            jsonData = JSON.parse(this.responseText);

            //console.log(this.responseText);

            //console.log(jsonData.titel);
            createBlogg();
            recurs(jsonData);
        }
    };


    xhttp.open("GET", "json/bloggjson.php?anvandare=2&blogg=2&inlagg=2", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
    }

//document.body.onload = function() {init();};

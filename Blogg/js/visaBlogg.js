
let jsonData;
let kommentarArray = new Array();
let index = 0;


function createBlogg() {

    createTitel();
    createInlagg();
    createSkribent();
    
    console.log(jsonData);
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
    //console.log(jsonData.bloggInlagg[0].titel);
    inlagg.id = "inlagg" + id;
    for (let i = 0; i < jsonData.bloggInlagg.length; i++) {
        
        let titleContainer = document.createElement("div");
        let title = document.createElement("h2");
        title.innerHTML = jsonData.bloggInlagg[i].titel;
        titleContainer.appendChild(title);
        inlagg.appendChild(titleContainer);
        for (let j = 0; j < jsonData.bloggInlagg[i].rutor.length; j++) {

            let element = document.createElement("div");
            
            let element2;
            
            if (jsonData.bloggInlagg[i].rutor[j].type === "textRuta") {

                element.className = "ruta textRuta";
                element.id = "inlagg" + id + "ruta" + j;
                if (jsonData.bloggInlagg[i].rutor[j].rubrik !== null) {

                    element2 = document.createElement("h3");
                    element2.innerHTML = jsonData.bloggInlagg[i].rutor[j].rubrik;
                    element.appendChild(element2);
                }

                element2 = document.createElement("p");
                element2.innerHTML = jsonData.bloggInlagg[i].rutor[j].text;
                element.appendChild(element2);
            } else {
                element.className = "ruta bildRuta";
                element.id = "ruta" + j;
                let element2 = document.createElement("img");
                element2.src = "images/kys.jpg";
                element2.alt = "KYS";
                element.appendChild(element2);
            }
            
            inlagg.appendChild(element);
        }
            inlagg.appendChild(document.createTextNode(jsonData.bloggInlagg[i].datum));
    }
    
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
            element2.innerHTML = kom.namn + ": " + kom.text + " : " + kom.hierarchyID;
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
            console.log(jsonData);
            //console.log(jsonData.titel);
            createBlogg();
            recurs(jsonData.bloggInlagg[0]);
        }
    };

    xhttp.open("GET", "Blogg/json/bloggjson.php?anvandare=1&blogg=2&inlagg=1", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
    }

document.body.onload = function() {init()};

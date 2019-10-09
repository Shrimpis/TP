let jsonData;
let kommentarArray = new Array();


function createBlogg() {

    createTitel();
    createInlagg();
    createSkribent();
    createKommentar();
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
function createKommentar() {
    let body = document.getElementById("kommentarContainer");
    let kommentar = document.createElement("div");

    for(let i = 0; i < jsonData.bloggInlagg.length; i++)
        for (let j = 0; j < jsonData.bloggInlagg[0].kommentarer.length; j++) {

            let element = document.createElement("div");
            element.id = "kommentar" + j;
            let element2;
            
            if (jsonData.bloggInlagg[0].kommentarer[j].hierarchyID == 0) {
                element2 = document.createElement("p");
                element2.innerHTML = jsonData.bloggInlagg[i].kommentarer[j].namn + ": " + jsonData.bloggInlagg[0].kommentarer[j].text;
                element.appendChild(element2);
            } else {
                element2 = document.createElement("div");
                let element3 = document.createElement("p");
                element3.innerHTML = jsonData.bloggInlagg[i].kommentarer[j].namn + ": " + jsonData.bloggInlagg[0].kommentarer[j].text;

                element2.appendChild(element3);
                element.appendChild(element2);
            }
            
            kommentar.appendChild(element);
  
    }
    
    body.appendChild(kommentar);
}



<<<<<<< HEAD:visaBlogg.js
=======
//Work in progress fully dynamisk kommentarsfält
/*function createKommentar() {
    let body = document.getElementById("kommentarContainer");
    let kommentar = document.createElement("div");
    

    for(let i = 0; i < jsonData.bloggInlagg.length; i++)
    {
        for (let j = 0; j < jsonData.bloggInlagg[i].kommentarer.length; j++) {
            //console.log(jsonData.bloggInlagg[i].kommentarer[j].text);
            if(jsonData.bloggInlagg[i].kommentarer[j].hierarchyID == 0) {
                let element = rekurs(jsonData.bloggInlagg[i].kommentarer[j].KID); 
                
                kommentar.appendChild(element); 
            }
            
        } 
    }
    
    //console.log(kommentar);
    body.appendChild(kommentar);
    
}


function rekurs(id) {
    let element, element2;
    kommentarArray.push(id);
    for(let i = 0; i < jsonData.bloggInlagg.length; i++) {
        
        for (let j = 0; j < jsonData.bloggInlagg[i].kommentarer.length; j++) {
            element = document.createElement("div");
            element.id = "kommentar" + j;
            
            //console.log(jsonData.bloggInlagg[i].kommentarer[j].hierarchyID + " " + id);
            if(jsonData.bloggInlagg[i].kommentarer[j].hierarchyID == id) {
                kommentarArray.push(jsonData.bloggInlagg[i].kommentarer[j].hierarchyID);
            
            }
            
        }
    }

    for(let i = 0; i < jsonData.bloggInlagg.length; i++){
        for(let j = 0; j < jsonData.bloggInlagg[i].kommentarer.length; j++) {
            console.log(kommentarArray.length);
            while(kommentarArray.length > 0) {
                element2 = document.createElement("p");
                element2.innerHTML = jsonData.bloggInlagg[i].kommentarer[j].text;
                element.appendChild(element2);
                console.log(jsonData.bloggInlagg[i].kommentarer[j].text);
                kommentarArray.splice(i);
            }
        }
    }

    console.log(element);
    return element;
    
}*/



>>>>>>> 4714569e9bdba91bc48dbfc0e5c0e7e6a96ac0a3:js/visaBlogg.js
function init() {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {

        if (this.readyState === 4 && this.status === 200) {
            
            jsonData = JSON.parse(this.responseText);
            console.log(jsonData);
            //console.log(jsonData.titel);
            createBlogg();
        }
    };

    xhttp.open("GET", "json/bloggjson.php?visa=anvandare&anvandare=1&blogg=1", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
    }

document.body.onload = function() {init()};
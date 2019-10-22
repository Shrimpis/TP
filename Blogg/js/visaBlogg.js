
let jsonData;
let index = 0;
let agare;
let flagga;
let bloggTitel;

function createBlogg() {

    createTitel();
    createInlagg();
    createSkribent();
<<<<<<< HEAD

=======
    createFlagga();

    
>>>>>>> master

}


//Dynamisk
function createSkribent() {
    let body = document.getElementById("skribentContainer");
    let element = document.createElement("p");
    let div = document.createElement("div");

    let skribent = document.createTextNode("Ägaren: " + agare);
    element.appendChild(skribent);
    div.appendChild(element);
    body.appendChild(div);
}


//Dynamisk
function createTitel() {
    let body = document.getElementById("headerContainer");
    let element = document.createElement("h1");
    let div = document.createElement("div");

    let titel = document.createTextNode(bloggTitel);
    element.appendChild(titel);
    div.appendChild(element);
    body.appendChild(div);
}

function createFlagga(){
    let body = document.getElementById("flaggaContainer");
    let element = document.createElement("p");
    let div = document.createElement("div");

    let flaggor = document.createTextNode("Flaggningar: " + flagga);
    element.appendChild(flaggor);
    div.appendChild(element);
    body.appendChild(div);

}


function createInlagg(id) {

    let body = document.getElementById("bloggInlaggContainer");
    let inlagg = document.createElement("div");
    //console.log(jsonData);
    inlagg.id = "inlagg" + 1;

    let divText = document.createElement("div");
    divText.innerHTML = jsonData.innehall;
    inlagg.appendChild(divText);
<<<<<<< HEAD

=======
>>>>>>> master
    body.appendChild(inlagg);


    let element = document.createElement("p");
    let gillaContainer = document.createElement("div");

    let gillningar = document.createTextNode("Gillningar: " + jsonData.gillningar.length);
    element.appendChild(gillningar);
    gillaContainer.appendChild(element);
    body.appendChild(gillaContainer);
}



//Dynamisk
function createKommentar(kom) {
    let body = document.getElementById("kommentarContainer");
    let kommentar = document.createElement("div");
<<<<<<< HEAD



=======
>>>>>>> master
            let element = document.createElement("div");
            //element.id = "kommentarKommentar";
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

            console.log(jsonData);

            agare = jsonData.anamn;
            flagga = jsonData.flaggningar;
            bloggTitel = jsonData.titel
            next();
        }
    };
    
    xhttp.open("GET", "json/bloggjson.php?anvandare=1&blogg=2", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
}

function next() {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            
            jsonData = JSON.parse(this.responseText);

<<<<<<< HEAD
    xhttp.open("GET", "json/bloggjson.php?anvandare=1&blogg=2", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
    }

//document.body.onload = function() {init();};
=======
            console.log(jsonData);
            createBlogg();
            recurs(jsonData);
        }
    };
    
    xhttp.open("GET", "json/bloggjson.php?anvandare=1&blogg=2&inlagg=2", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
}
    
    document.body.onload = function() {init();};
>>>>>>> master

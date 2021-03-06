
let jsonData;
let index = 0;
let agare;
let flagga;
let bloggTitel;



//Dynamisk. Skriver ut vem som äger bloggen
function createSkribent() {
    let body = document.getElementById("skribentContainer");
    let element = document.createElement("p");
    let div = document.createElement("div");

    let skribent = document.createTextNode("Ägaren: " + agare);
    element.appendChild(skribent);
    div.appendChild(element);
    body.appendChild(div);
}


//Dynamisk. Skapar titeln på bloggen
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


//Skapar inlägg
function createInlagg(id) {

    let body = document.getElementById("bloggInlaggContainer");


    let br = document.createElement("br");
    body.appendChild(br);

    //Skapar titeln till inlägget
    let titel = document.createElement("h3");
    let titelContainer = document.createElement("div");
    titelContainer.id = "titelContainer" + id;
    let titelValue = document.createTextNode(jsonData.titel);
    titel.appendChild(titelValue);
    titelContainer.appendChild(titel);
    body.appendChild(titelContainer);

    //Skapar datumet till inlägget
    let datumElement = document.createElement("h");
    let datumContainer = document.createElement("div");
    datumContainer.id = "datumContainer" + id;
    let datumValue = document.createTextNode(jsonData.datum);
    datumElement.appendChild(datumValue);
    datumContainer.appendChild(datumElement);
    body.appendChild(datumContainer);

    //Skapar innehållet till inlägget
    let inlagg = document.createElement("div");
    inlagg.id = "inlagg" + id;
    let divText = document.createElement("div");
    divText.innerHTML = jsonData.innehall;
    inlagg.appendChild(divText);
    body.appendChild(inlagg);


    //skapar gillningar till inlägget
    let element = document.createElement("p");
    let gillaContainer = document.createElement("div");
    gillaContainer.id = "gillaContainer" + id;
    let gillningar = document.createTextNode("Gillningar: " + jsonData.gillningar.length);
    element.appendChild(gillningar);
    gillaContainer.appendChild(element);
    body.appendChild(gillaContainer);

}



//Dynamisk. Skapar kommentarer.
function createKommentar(kom) {
    let body = document.getElementById("bloggInlaggContainer");
    let kommentar = document.createElement("div");
    let element = document.createElement("div");
    let element2;


    element2 = document.createElement("p");
    element2.innerHTML = kom.namn + ": " + kom.innehall;
    element.appendChild(element2);
    kommentar.appendChild(element);
    body.appendChild(kommentar);

    let element3 = document.createElement("p");
    let flaggaContainer = document.createElement("div");
    element3.innerHTML = "Flaggningar: " + kom.flaggningar;
    flaggaContainer.appendChild(element3);
    body.appendChild(flaggaContainer);



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

            agare = jsonData.anamn;
            flagga = jsonData.flaggningar;
            bloggTitel = jsonData.titel
            createSkribent();
            createFlagga();
            createTitel();
            console.log(jsonData.bloggInlagg.length);
            for(let i = 1; i <= jsonData.bloggInlagg.length; i++) {
                next(i);
            }
        }
    };
    xhttp.open("POST", "../json/bloggjson.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send("anvandare=" + anvandarId + "&blogg=" + bloggId);
}

function next(id) {
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            jsonData = JSON.parse(this.responseText);
            //console.log(this.responseText);
            console.log(jsonData);
            
            //console.log(jsonData);
            createInlagg(id);
            index = 0;
            recurs(jsonData);
        }
    };
    
    xhttp.open("POST", "../json/bloggjson.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send("anvandare=" + anvandarId + "&blogg=" + bloggId + "&inlagg=" + id);
}
    
document.body.onload = function() {init();};

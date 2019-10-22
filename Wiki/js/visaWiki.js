let jsonData;


function createWiki() {

    getTitel();
    getAdmin();
    for(let i = 0; i < jsonData.wiki.sidor.length; i++) {
        getSida(i);
    }
}

function getTitel() {
    let body = document.getElementById("headerContainer");
    let element = document.createElement("h2");
    let div = document.createElement("div");

    let titel = document.createTextNode(jsonData.wiki.titel);
    element.appendChild(titel);
    div.appendChild(element);
    body.appendChild(div);
}

function getAdmin() {
    let body = document.getElementById("adminContainer");
    let element = document.createElement("p");
    let div = document.createElement("div");

    let admin = document.createTextNode(jsonData.wiki.anvandarnamn);
    element.appendChild(admin);
    div.appendChild(element);
    body.appendChild(div);
}

function getSida(i) {

    //Hämtar titeln på wikisidan
    let body = document.getElementById("sidaContainer");
    let element = document.createElement("h4");
    let div = document.createElement("div");
    let titel = document.createTextNode(jsonData.wiki.sidor[i].titel)
    element.appendChild(titel);
    div.appendChild(element);
    body.appendChild(div);

    //Hämtar innehållet på wikisidan
    let element2 = document.createElement("p")
    let div2 = document.createElement("div");
    let innehall = document.createTextNode(jsonData.wiki.sidor[i].innehall);
    element2.appendChild(innehall);
    div2.appendChild(element2);
    body.appendChild(div2);

    //Hämtar datumet på sidan
    let element3 = document.createElement("p");
    let div3 = document.createElement("div");
    let datum = document.createTextNode(jsonData.wiki.sidor[i].datum);
    element3.appendChild(datum);
    div3.appendChild(element3);
    body.appendChild(div3);

    //Hämtar namnet på bidragaren
    let element4 = document.createElement("p");
    let div4 = document.createElement("div");
    let bidragsgivare = document.createTextNode("Bidragare: " + jsonData.wiki.sidor[i].bidragsgivareNamn + "    Godkännare: " + jsonData.wiki.sidor[i].godKantAvNamn);
    element4.appendChild(bidragsgivare);
    div4.appendChild(element4);
    body.appendChild(div4);


}

function init() {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            jsonData = JSON.parse(this.responseText);
            console.log(jsonData);
            createWiki();
        }
    };

    xhttp.open("GET", "json/wikijson.php?anvandare=1", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    xhttp.send();
    }

document.body.onload = function() {init();};



























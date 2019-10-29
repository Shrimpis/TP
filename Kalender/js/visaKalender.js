
let json;



function getTitel(){
    let body = document.getElementById("titelContainer");
    let titel = document.createElement("h2");
    let titelCon = document.createElement("div");

    let titelValue = document.createTextNode(json.titel);
    titel.appendChild(titelValue);
    titelCon.appendChild(titel);
    body.appendChild(titelCon);
}

function getAgare(){
    let body = document.getElementById("agareContainer");
    let agare = document.createElement("p");
    let agareCon = document.createElement("div");
    let agareValue = document.createTextNode(json.anamn);
    agare.appendChild(agareValue);
    agareCon.appendChild(agare);
    body.appendChild(agareCon);
}

function getEvent(i){

    //Skapar titeln till eventet
    let body = document.getElementById("eventContainer");
    let titel = document.createElement("h4");
    let titelCon = document.createElement("div");
    let titelValue = document.createTextNode(json.event[i].titel);
    titel.appendChild(titelValue);
    titelCon.appendChild(titel);
    body.appendChild(titelCon);

    //Skapa skapare
    let skapare = document.createElement("p");
    let skapareCon = document.createElement("div");
    let skapareValue = document.createTextNode("Skapad av: " + json.event[i].skapadAv);
    skapare.appendChild(skapareValue);
    skapareCon.appendChild(skapare);
    body.appendChild(skapareCon);

    //Skapa innehåll till eventet
    let innehall = document.createElement("p");
    let innehallCon = document.createElement("div");
    let innehallValue = document.createTextNode(json.event[i].innehall);
    innehall.appendChild(innehallValue);
    innehallCon.appendChild(innehall);
    body.appendChild(innehallCon);

    //Skapa tid för event
    let tid = document.createElement("p");
    let tidCon = document.createElement("div");
    let tidValue = document.createTextNode(json.event[i].startTid + " till " + json.event[i].slutTid);
    tid.appendChild(tidValue);
    tidCon.appendChild(tid);
    body.appendChild(tidCon);

}

function init(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            json = JSON.parse(this.responseText);
            console.log(json);
            console.log(json.titel);

            getTitel();
            next();
        }
    };

    xhttp.open("POST", "json/kalenderjson.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("anvandare=" + anvandarId + "&kalender=" + kalenderId);
}

function next(){
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            json = JSON.parse(this.responseText);
            console.log(json);

            getAgare();
            for(let i = 0; i < json.event.length; i++) {
                getEvent(i);
            }
            
        }
    };

    xhttp.open("POST", "json/kalenderjson.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("anvandare=" + anvandarId + "&kalenderSida=" + sidId);
}

document.body.onload = function() {init();};






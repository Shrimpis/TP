

function getJsonData() {

    var http = new XMLHttpRequest();

    http.onreadystatechange = function () {

        if (this.status === 200 && this.readystate === 4) {
            
        }

    };

    http.open("GET", "asd.php", true);
    http.send();
}

function createInlagg(id) {

    let body = document.getElementById("bloggInlaggContainer");
    let inlagg = document.createElement("div");
    inlagg.id = "inlagg"+id;
    for (let i = 0; i < 6; i++) {
        
        
        let element = document.createElement("div");
        
        if(i <3){
            
            element.className = "ruta textRuta";
            element.id ="inlagg"+id+"ruta"+i;
            let element2 = document.createElement("h3");
            element2.innerHTML = "Title";
            element.appendChild(element2);
            element2 = document.createElement("p");
            element2.innerHTML = "KYSKYSKYSKYSKYSKYS";
            element.appendChild(element2);
        }else {
            element.className = "ruta bildRuta";
            element.id = "ruta"+i;
            let element2 = document.createElement("img");
            element2.src = "images/kys.jpg";
            element2.alt = "KYS";
            element.appendChild(element2);
            
        }
        inlagg.appendChild(element);
    }
    
    body.appendChild(inlagg);
}

function createBlogg() {

    createTitel("Detta är en titel");
    

    for(let i = 0; i < 6; i++) {
       createInlagg(i);
       
    }

    createKommentar("Detta är en kommentar");

    

}

function createTitel(TITEL) {
    let body = document.getElementById("headerContainer");
    let element = document.createElement("h2");
    let div = document.createElement("div");
    //element.setAttribute("headerContainer", "titel");
    

   // let titelFormat = document.createElement("h2");
    let titel = document.createTextNode(TITEL);
    //titelFormat.appendChild(titel);
    element.appendChild(titel);
    div.appendChild(element);
    body.appendChild(div);
}

function createKommentar() {
    let body = document.getElementById("kommentarContainer");
    let element = document.createElement("p");
    let div = document.createElement("div");
    //element.setAttribute("kommentarContainer", "kommentar");

    let kommentar = document.createTextNode("KOMMENTAR");
    element.appendChild(kommentar);
    div.appendChild(element);
    body.appendChild(div);

}

function init() {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {

        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            var jsonData = JSON.parse(this.responseText);
            
            createBlogg();
        }
    };

    xhttp.open("GET", "json/bloggjson.php?anvandare=1&blogg=1", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");

    xhttp.send();
    }

document.body.onload = function() {init()};

let rutaOrdning = 0;

        function laggTillTextruta() {

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.name = "textruta";

            let rubrik = document.createElement("div");
            let rubrikInnehall = document.createTextNode("Rubrik Paragraf: ");
            let rubrikInput = document.createElement("input");
            rubrikInput.type = "text";
            rubrikInput.name = "rubrik" + rutaOrdning;
            rubrik.appendChild(rubrikInnehall);
            rubrik.appendChild(rubrikInput);
            ruta.appendChild(rubrik);

            let breakLine = document.createElement("br");
            rubrik.appendChild(breakLine);
            rubrik.appendChild(breakLine);

            let text = document.createElement("div");
            let textInnehall = document.createTextNode("Text Paragraf: ");
            let textInput = document.createElement("textarea");
            textInput.name = "text" + rutaOrdning;
            textInput.placeholder = "Skriv in ett inlägg här...";
            text.appendChild(textInnehall);
            text.appendChild(breakLine);
            text.appendChild(textInput);
            ruta.appendChild(text);
            body.appendChild(ruta);

        }

        function laggTillBildruta(){

            rutaOrdning++;

            let body = document.getElementById("rutor-container");
            let ruta = document.createElement("div");
            ruta.name = "bildruta";

            let bild = document.createElement("div");
            let bildInnehall = document.createTextNode("Bild: ");
            let bildInput = document.createElement("input");
            bildInput.type = "text";
            bildInput.name = "bild" + rutaOrdning;
            bild.appendChild(bildInnehall);
            bild.appendChild(bildInput);
            ruta.appendChild(bild);
            body.appendChild(ruta);

        }
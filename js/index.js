const API_URL_RECETAS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/recetas.php';
const API_URL_TIPOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/tipos.php';
const API_URL_ALERGENOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/alergenos.php';
const API_URL_RECETAS_ALERGENOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/recetas_alergenos.php';

let listaRecetas = []
let listaTipos = []
let listaAlergenos = []

function mostrarModal (e){
    id = e.target.getAttribute('data-id')
    receta = listaRecetas.find(receta => receta.id == id)
    // tipoSeleccionado = listaTipos.find(tipo => receta.id_tipo == tipo.id)

    // Get the modal
    var modalMain = document.getElementById("myBtn");
    var modal = document.getElementById("modalContent");

    fetch(`${API_URL_RECETAS_ALERGENOS}?id_receta=${receta.id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        
        .then(alergenosReceta => {
            console.log('Alérgenos de la receta:', alergenosReceta);

            // Obtener los IDs de los alérgenos
            const idsAlergenos = alergenosReceta.map(relacion => relacion.id_alergenos);
            // Hacer una llamada a la API de alérgenos para obtener los nombres
            return fetch(`${API_URL_ALERGENOS}?ids=${idsAlergenos.join(',')}`)
                .then(res => res.json())
        })
        .then(alergenos => {
            const nombresAlergenos = alergenos.map(alergenos => alergenos.nombre).filter(nombre => nombre)

        modal.innerHTML = ''

        modal.innerHTML += `
            <span class="close">&times;</span>
            <div class="parent">
                <div class="img_modal">
                    <img src="${receta.img}" alt="Imagen de receta">
                </div>
                <div class="info_modal">
                    <h2>${receta.nombre}</h2>
                    <hr>
                    <p class="descripcion">
                        ${receta.descripcion !== null ? receta.descripcion : ' '}
                    </p>
                        ${receta.descripcion !== null ? '<hr>' : ' '}
                    <div class="mainDatos">
                        <div class="datillos1">
                            <span class="datosModal">
                                ${receta.comensales !== null ? `Comesales: ${receta.comensales}` : ''}
                            </span>
                            <br>                        
                            <span class="datosModal">
                                ${receta.preparacion !== null ? `Tiempo de preparación: ${receta.preparacion}` : ''}
                            </span>
                        </div>
                        <div class="datillos2">
                            <span class="datosModal">
                                ${receta.cocinar !== null ? `Tiempo de cocina: ${receta.cocinar}` : ''}
                            </span>
                            <br>
                            <span class="datosModal">
                                ${receta.temperatura !== null ? `Temperatura: ${receta.temperatura}` : ''}
                            </span>
                        </div>
                    </div>
                    <hr class="separation">
                </div>
                <div class="ingre_modal">
                    <span>${receta.ingredientes}</span>
                </div>
                <div class="receta_modal">
                    <span>${receta.pasos}</span>
                </div>
                <div class="alerg_modal">
                    <ul>
                        ${nombresAlergenos.length > 0 ? nombresAlergenos.map(nombre => `<li>${nombre}</li>`).join('') : '<p>No hay alérgenos asociados.</p>'}
                    </ul>
                </div>
                <div class="download_modal">
                    <p>INSERTAR BOTON QUE DESCARGUE LA INFO DEL MODAL CON SU ESTRUCTURA</p>
                </div>
            </div>
        `

        modalMain.style.display = "block"

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modalMain.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modalMain) {
                modalMain.style.display = "none";
            }
        }
    })
    .catch(error => console.log('Error:', error));
}

function getTipos(){
    fetch(API_URL_TIPOS)
        .then(response => response.json())
        .then(tipos => {
            listaTipos = tipos
            getAlergenos()
        })
        .catch(error => console.log('Error:', error))
}

function getAlergenos(){
    fetch(API_URL_ALERGENOS)
        .then(response => response.json())
        .then(alergenos => {
            listaAlergenos = alergenos
            getRecetas()
        })
        .catch(error => console.log('Error:', error))
}

function getRecetas(){
    fetch(API_URL_RECETAS)
        .then(response => response.json())
        .then(recetas => {
            listaRecetas = recetas
            const cuerpo = document.querySelector('#mainContainer')
            cuerpo.innerHTML = ''

            recetas.forEach(receta => {
                tipoSeleccionado = listaTipos.find(tipo => receta.id_tipo == tipo.id)

                cuerpo.innerHTML += `
                    <div class="tarjetas">
                        <div>
                            <img src="${receta.img}" alt="">
                        </div>
                        <div class="info">
                        <h2>${receta.nombre}</h2>
                            <div class="infoComesales">
                                <div class="descripcionTarjetas">
                                    <p class="descripcionLimit">${receta.descripcion !== null ? receta.descripcion : ' '}</p>
                                </div>
                                <div class="comensales">
                                    <span>${receta.comensales}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <center><button data-id="${receta.id}" class="modalContent">MAS INFORMACION</button></center>
                        </div>
                    </div>
                `

                
            });
            const botonesPelis = document.querySelectorAll('.modalContent')

            botonesPelis.forEach(botonPeli => {
                botonPeli.addEventListener('click', mostrarModal)
            })
        })
        .catch(error => console.log('Error:', error))
}

getTipos()
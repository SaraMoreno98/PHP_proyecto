// URLs de las APIs
const API_URL_RECETAS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/recetas.php';
const API_URL_TIPOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/tipos.php';
const API_URL_ALERGENOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/alergenos.php';
const API_URL_RECETA_ALERGENOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/recetas_alergenos.php';

// Arrays para almacenar datos
let listaRecetas = []
let listaTipos = []
let listaAlergenos = []
let listaAlergenosReceta = []

/**
 * Muestra el modal con la información detallada de una receta
 * @param {Event} e - Evento del click
 */
function mostrarModal (e){
    // Obtiene el ID de la receta desde el botón
    id = e.target.getAttribute('data-id')
    receta = listaRecetas.find(receta => receta.id == id)

    // Obtiene elementos del modal
    var modalMain = document.getElementById("myBtn");
    var modal = document.getElementById("modalContent");

    // Obtiene los alérgenos de la receta
    fetch(API_URL_RECETA_ALERGENOS)
        .then(response => response.json())
        .then(receta_alergenos => {
            getRecetas()
            listaAlergenosReceta = receta_alergenos;

            // Filtra los alérgenos de la receta actual
            const idsAlergenosReceta = listaAlergenosReceta
                // Filtrar solo los alérgenos de la receta actual
                .filter(relacion => relacion.id_receta == id)
                .map(relacion => relacion.id_alergenos);

            // Construye el texto de alérgenos
            let alergenosPorRecetaTxt = '';
            idsAlergenosReceta.forEach(id => {
                let alergeno = listaAlergenos.find(a => a.id === id);
                if (alergeno) {
                    alergenosPorRecetaTxt += `${alergeno.nombre} `;
                }
            });

            // Construye el contenido del modal
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
                        <h2>Alérgenos</h2>
                        ${alergenosPorRecetaTxt}
                    </div>
                </div>
            `
            // Muestra el modal
            modalMain.style.display = "block"

            // Configura el cierre del modal
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
            modalMain.style.display = "none";
            }

            // Cierra el modal al hacer clic fuera
            window.onclick = function(event) {
                if (event.target == modalMain) {
                    modalMain.style.display = "none";
                }
            }
        })
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
            // console.log(listaAlergenos)
            getRecetas()
        })
        .catch(error => console.log('Error:', error))
}

function getRecetas() {
    fetch(API_URL_RECETAS)
        .then(response => response.json())
        .then(recetas => {
            listaRecetas = recetas;
            mostrarRecetas(recetas); // Mostrar todas las recetas inicialmente

            const enlacesTipo = document.querySelectorAll('.nav');
            enlacesTipo.forEach(enlace => {
                enlace.addEventListener('click', (e) => {
                    e.preventDefault();
                    const tipoSeleccionado = e.target.getAttribute('data-tipo');
                    if (tipoSeleccionado === 'all') {
                        mostrarRecetas(listaRecetas); // Mostrar todas las recetas
                        document.getElementById('mostrar-todas').style.display = 'none'; // Ocultar enlace después de mostrar todas
                    } else {
                        filtrarRecetasPorTipo(tipoSeleccionado);
                        document.getElementById('mostrar-todas').style.display = 'inline'; // Mostrar el enlace "Mostrar Todas"
                    }
                });
            });
        })
        .catch(error => console.log('Error:', error));
}

function mostrarRecetas(recetas) {
    const cuerpo = document.querySelector('#mainContainer');
    cuerpo.innerHTML = '';

    recetas.forEach(receta => {
        cuerpo.innerHTML += `
            <div class="tarjetas">
                <div>
                    <img src="${receta.img}" alt="">
                </div>
                <div class="info">
                    <h2>${receta.nombre}</h2>
                    <div class="infoComesales">
                        <div class="descripcionTarjetas">
                            <p class="descripcionLimit">${receta.descripcion || ' '}</p>
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
        `;
    });

    const botonesPelis = document.querySelectorAll('.modalContent');
    botonesPelis.forEach(botonPeli => {
        botonPeli.addEventListener('click', mostrarModal);
    });
}

function filtrarRecetasPorTipo(tipoSeleccionado) {
    const recetasFiltradas = listaRecetas.filter(receta => receta.id_tipo == tipoSeleccionado);
    mostrarRecetas(recetasFiltradas);
}

getTipos()
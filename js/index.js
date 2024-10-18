const API_URL_RECETAS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/recetas.php';
const API_URL_TIPOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/tipos.php';
const API_URL_ALERGENOS = 'http://localhost/PHP/PHP_PROYECTO/php/controllers/alergenos.php';

let listaRecetas = []
let listaTipos = []
// let listaAlergenos = []

function mostrarModal (e){
    id = e.target.getAttribute('data-id')
    // console.log(id)

    receta = listaRecetas.find(receta => receta.id == id)
    tipoSeleccionado = listaTipos.find(tipo => receta.id_tipo == tipo.id)

    // console.log(receta)

    // Get the modal
    var modalMain = document.getElementById("myBtn");
    var modal = document.getElementById("modalContent");

    modal.innerHTML = ''

    modal.innerHTML += `
        <span class="close">&times;</span>
        <div class="parent">
            <div class="div1">
                <img src="administracion/${receta.img}" alt="Imagen de receta">
            </div>
            <div class="mainInfo">
                <h2>${receta.nombre}</h2>
                <span class="descripcion">${receta.descripcion}</span>
                <hr>
                <span class="precioModal">${receta.comensales}</span>
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
}

function getTipos(){
    fetch(API_URL_TIPOS)
        .then(response => response.json())
        .then(tipos => {
            listaTipos = tipos
            getRecetas()
        })
        .catch(error => console.log('Error:', error))
}

// function getAlergenos(){
//     fetch(API_URL_ALERGENOS)
//         .then(response => response.json())
//         .then(alergenos => {
//             listaAlergenos = alergenos
//             getRecetas()
//         })
//         .catch(error => console.log('Error:', error))
// }

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
                            <img src="administracion/${receta.img}" alt="Poster de película">
                        </div>
                        <div class="info">
                        <h2>${receta.nombre}</h2>
                            <div class="directPrecio">
                                <div class="director">
                                    <p>${tipoSeleccionado.nombre}</p>
                                </div>
                                <div class="precio">
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
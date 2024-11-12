// Obtener referencias a los elementos modales
const modalRegistro = document.getElementById('miModalRegistro')
const modalRecuperar = document.getElementById('miModalRecuperar')

// Obtener referencias a los botones que abren los modales
const btnRegistro = document.querySelector('.abrir_modal_registro')
const btnRecuperar = document.querySelector('.abrir_modal_recuperar')

// Obtener referencias a los elementos que cierran los modales
const spanRegistro = document.querySelector('.cerrarRegistro')
const spanRecuperar = document.querySelector('.cerrarRecuperar')

// Función para abrir el modal de registro
btnRegistro.onclick = function (){
    modalRegistro.style.display = "flex";
}

// Función para abrir el modal de recuperación
btnRecuperar.onclick = function(){
    modalRecuperar.style.display = "flex";
}

// Función para cerrar el modal de registro al hacer clic en la X
spanRegistro.onclick = function(){
    modalRegistro.style.display = "none";
}

// Función para cerrar el modal de recuperación al hacer clic en la X
spanRecuperar.onclick = function(){
    modalRecuperar.style.display = "none";
}

// Función para cerrar los modales al hacer clic fuera de ellos
window.onclick = function(event){
    if(event.target == modalRegistro){
        modalRegistro.style.display = "none"
    }

    if(event.target == modalRecuperar){
        modalRecuperar.style.display = "none"
    }
}
// Función para alternar el menú responsive
function toggleMenu() {
    let myNav = document.getElementById('tipos-nav');
    // Si la clase es 'navbar', añade 'responsive', si no, vuelve a 'navbar'
    if(myNav.className === 'navbar'){
        myNav.className += " responsive"
    }else{
        myNav.className = "navbar"
    }
}

// Añade el evento click al botón del menú
document.getElementById('boton').addEventListener('click', toggleMenu);
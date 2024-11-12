<?php
// Iniciar sesión para mantener el estado del usuario
session_start();

// Si el usuario ha iniciado sesión, redirigir al panel de administración
if(isset($_SESSION['user_id'])){
    header('Location: administracion/adminPelicula.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="img/bandeja-de-comida.png" type="image/x-icon">
        <link rel="stylesheet" href="css/index.css">
        <title>Recetas Sin Gluten</title>
    </head>
    
    <body>
        <!-- Cabecera con navegación -->
        <header>
            <div>
                <img class="logoImg" src="img/Isotipo.png" alt="Isotipo El Jardín sin gluten de Bolson Cerrado">
            </div>
            <!-- Menú de navegación para tipos de recetas -->
            <nav class="navbar" id="tipos-nav">
                <a href="#" class="nav" data-tipo="all" id="mostrar-todas" style="display: none;">Mostrar Todas</a>
                <a href="#" class="nav" data-tipo="1">Desayuno</a>
                <a href="#" class="nav" data-tipo="2">Segundo desayuno</a>
                <a href="#" class="nav" data-tipo="3">Desayuno de Media Mañana</a>
                <a href="#" class="nav" data-tipo="4">Almuerzo</a>
                <a href="#" class="nav" data-tipo="5">Merienda</a>
                <a href="#" class="nav" data-tipo="6">Cena</a>
                <a href="#" disabled class="icon" id="boton" >&#9776;</a>
            </nav>
        </header>

        <main>
        <!-- Contenedor para tarjetas de recetas -->
            <div class="mainContainer" id="mainContainer">
                <!-- Contenido cargado dinámicamente mediante JS -->
            </div>

        <!-- Modal para vista detallada de recetas -->
            <div id="myBtn" class="modal">
                <div class="modal_content" id="modalContent">
                    <!-- Contenido cargado dinámicamente mediante JS -->
                </div>
            </div>
        </main>

        <script src="js/index.js"></script>
        <script src="js/navbar.js"></script>
    </body>

    <!-- Pie de página con enlaces sociales e inicio de sesión -->
    <footer>
        <div class="footer1">
            <a href="https://github.com/SaraMoreno98" target="_blank">GitHub</a>
            <a href="https://es.linkedin.com/in/sara-moreno-ontiveros" target="_blank">LinkedIn</a>
            <a href="https://www.instagram.com/saramo_graphic/" target="_blank">Instagram</a>
        </div>
        <div class="footer2">
            <a href="login.php" class="btn-login">Login</a>
        </div>
        <div class="footer3">
            <p>&copy; Sara Moreno Ontiveros</p>
        </div>
    </footer>
</html>

<!-- METER LOGO SUPER CHULI EN EL HEADER -->
<!-- FIX MAIL SENDING OPTIONS -->
<!-- UPLOAD IT TO THE SERVER AND TRY IT OUT -->
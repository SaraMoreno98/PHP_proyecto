<?php
// Iniciar sesión para mantener el estado del usuario
session_start();

// Comprobar si hay mensajes de éxito/error en la sesión
if(isset($_SESSION['success']) && isset($_SESSION['message'])){
    $mensaje = $_SESSION['message'];
    $success = $_SESSION['success'];

    // Limpiar el mensaje de la sesion para que no se muestre de nuevo
    unset($_SESSION['message']);
    unset($_SESSION['success']);

    // Mostramos el mensaje
    echo "<div class='mensaje $success'>$mensaje</div>";
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="img/bandeja-de-comida.png" type="image/x-icon">
        <link rel="stylesheet" href="css/login.css">
        <title>Sistema de login</title>
    </head>
    <body>
        <!-- Formulario principal de acceso -->
        <div class="container">
            <form method="POST" action="php/controllers/recetas.php">
                <h2>Login</h2>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <a class="abrir_modal_recuperar">Recuperar contraseña</a>
                <input type="submit" name="login" value="Iniciar sesión">
            </form>
            <p>¿Necesitas una cuenta? <a class="abrir_modal_registro">Registrarse</a></p>
            <a class="return" href="index.php">Volver a recetas</a>
        </div>

    <!-- Modal -> Recuperación de contraseña -->
        <div id="miModalRecuperar" class="modal">
            <div class="modal_contenido">
                <span class="cerrarRecuperar">&times;</span>
                <h2>Recuperar contraseña</h2>
                <form method="POST" action="php/controllers/recetas.php">
                    <input type="email" name="email" placeholder="Correo electronico">
                    <input type="submit" name="recuperar" value="Recuperar Contraseña">
                </form>
            </div>
        </div>

    <!-- Modal -> Registro -->
        <div id="miModalRegistro" class="modal">
            <div class="modal_contenido">
                <span class="cerrarRegistro">&times;</span>
                <h2>Registro</h2>
                <form method="POST" action="php/controllers/recetas.php">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="email" name="email" placeholder="Correo electronico">
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <input type="submit" name="registro" value="Registrarse">
                </form>
            </div>
        </div>

        <script src="js/login.js"></script>
    </body>
</html>
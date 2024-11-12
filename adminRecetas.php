<?php
// Iniciar sesión para mantener el estado del usuario
session_start();

// Comprobar si el usuario está conectado, si no redirigir a la página de índice
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="img/bandeja-de-comida.png" type="image/x-icon">
        <link rel="stylesheet" href="css/adminRecetas.css">
        <title>Admin</title>
    </head>
    <body>
        <?php
        // Mostrar el botón de cierre de sesión sólo si el usuario está conectado
            if(isset($_SESSION['user_id'])){
        ?>
                <div class="cerrar_sesion">
                    <a href="close_session.php">Cerrar sesión</a>
                </div>
        <?php
            };
        ?>
        <!-- Formulario de creación de recetas -->
        <h2>Crear Receta</h2>
        <form id="createForm">
            <!-- Campos de entrada para los detalles de la receta -->
            <input type="text" id="createNombre" placeholder="Nombre" required>
            <select name="tipo" id="selectTipo"></select>
            <textarea name="descripcion" id="createDescripcion" maxlength="500" placeholder="Introduzca una descripción de no más de 500 caracteres"></textarea>
            <input type="text" id="createComesales" placeholder="Comensales" required>
            <input type="text" id="createPreparacion" placeholder="Preparacion" required>
            <input type="text" id="createCocinar" placeholder="Cocinar">
            <input type="text" id="createTemperatura" placeholder="Temperatura">
            <textarea name="ingredientes" id="createIngredientes" maxlength="500" placeholder="Introduzca los ingredientes en no más de 500 caracteres"></textarea>
            <!-- <select name="alergenos" id="selectAlergenos"></select> -->
            <div id="selectAlergenos"></div>
            <textarea name="pasos" id="createPasos" maxlength="6500" placeholder="Introduzca los pasos en no más de 6500 caracteres"></textarea>

            <button type="submit">CREAR RECETA</button>

            <div id="createError" class="error"></div>
        </form>

        <!-- Tabla para visualizar las recetas existentes -->
        <h2>Recetas</h2>
        <table id="recetasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Comensales</th>
                    <th>Preparación</th>
                    <th>Cocinar</th>
                    <th>Temperatura</th>
                    <th>Ingredientes</th>
                    <th>Alérgenos</th>
                    <th>Pasos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>

        <script src="js/recetas.js"></script>
    </body>
</html>
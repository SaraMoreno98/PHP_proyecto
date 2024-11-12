<?php
// Incluir conexión a base de datos y funciones de usuario
include_once 'php/data/receta.php';

// Crear una nueva instancia de conexión a la base de datos
$usuarioBd = new UsuarioBD();

// Comprobar si se proporciona el token de restablecimiento de contraseña
if(isset($_GET['token'])){
    $token = $_GET['token'];

    // Gestión del envío del formulario de restablecimiento de contraseña
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset(($_POST['nueva_password']))){
        $resultado = $usuarioBd->restablecerContraseña($token, $_POST['nueva_password']);
        $mensaje = $resultado['message'];
    }
}else{
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/index.css">
        <title>Restablecer contraseña</title>
    </head>
    <body>
        <div class="container">
            <h1>Restablecer contraseña</h1>
            <?php if(!empty($mensaje)): ?>
                <!-- Mostrar mensaje de resultado -->
                <p class = "mensaje"><?php echo $mensaje; ?></p>
            <?php if($resultado['success']): ?>
                <!-- Mostrar enlace de inicio de sesión si el restablecimiento de contraseña se ha realizado correctamente -->
                <a href="login.php" class = "boton">Ir a Iniciar Sesión</a>
            <?php endif;
                else: 
            ?>
                <!-- Formulario de restablecimiento de contraseña -->
                <form method="POST">
                    <input type="password" name="nueva_password" placeholder="Nueva Contraseña" required>
                    <input type="password" name="confirmar_password" placeholder="Confirmar Nueva Contraseña" required>
                    <input type="submit" value="Restablecer Contraseña">
                </form>
                <?php endif; ?>
        </div>

        <script src="js/restablecer.js"></script>
    </body>
</html>
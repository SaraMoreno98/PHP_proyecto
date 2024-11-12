<?php
// Incluye el archivo que contiene la clase UsuarioBD
include_once 'php/data/receta.php';

// Crea una instancia de la clase UsuarioBD
$usuarioBd = new UsuarioBD();

// Verifica si se ha recibido un token por GET
if(isset($_GET['token'])){
    $token = $_GET['token'];
    // Verifica el token y obtiene el resultado
    $resultado = $usuarioBd->verificarTokens(($token));
    $mensaje = $resultado['message'];
}else{
    // Si no hay token, redirige al login
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verificación de cuenta</title>
    </head>
    <body>
        <div class="container">
            <h1>Verificación de cuenta</h1>
            <!-- Muestra el mensaje de resultado de la verificación -->
            <p class="mensaje"><?php echo $mensaje;?></p>
            <a href="login.php" class="boton">Ir a iniciar sesión</a>
        </div>
    </body>
</html>
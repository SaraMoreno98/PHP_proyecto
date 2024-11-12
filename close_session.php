<?php
    // Iniciar sesión para mantener el estado del usuario
    session_start();

    // Destruir todos los datos de la sesión
    session_destroy();
    // Borrar todas las variables de sesión
    session_unset();
    // Redirección a la página de índice después de cerrar la sesión
    header('Location: index.php');
    exit();
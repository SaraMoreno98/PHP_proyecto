<?php
    require 'includes/funciones_peliculas.php';
    $lista_peliculas = obtener_peliculas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <header>

        </header>
        <main>
            <h1>Películas</h1>
            <div class="listado-peliculas">
                <?php
                    while($pelicula = mysqli_fetch_assoc($lista_peliculas)){ ?>
                        <section class="pelicula">
                            <p><?php echo $pelicula['titulo']; ?></p>
                            <p class="precio"><?php echo $pelicula['precio']; ?> €</p>
                            <button class="verMas">Ver más</button>
                        </section>
                  <?php }
                ?>
                
            </div>
        </main>
        <footer>

        </footer>
        
    </div>
</body>
</html>
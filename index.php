<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Incluye el archivo que contiene la conexión a la base de datos
include('db.php');

// Verifica si el método de la solicitud es POST (cuando se envía el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene el nombre de usuario y la contraseña desde el formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepara una consulta para buscar el usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    // Ejecuta la consulta pasando el nombre de usuario como parámetro
    $stmt->execute(['username' => $username]);
    // Obtiene el resultado de la consulta, que será un solo registro si se encuentra el usuario
    $user = $stmt->fetch();

    // Si el usuario es encontrado y la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        // Almacena el ID del usuario y su nombre de usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Redirige a la página de recetas (o la página principal del sistema)
        header('Location: recipes.php');
        // Detiene la ejecución del script para evitar más código después de la redirección
        exit();
    } else {
        // Si el usuario o la contraseña no coinciden, muestra un error
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Especifica el conjunto de caracteres que se va a usar en la página -->
    <meta charset="UTF-8">
    <!-- Define el título de la página -->
    <title>Login</title>
  
</head>
<body>
    <header class="main-header">
        <h1>Recetario familiar</h1>
        <p>Bienvenido a la familia, ahora puedes subir tu receta favorita para que se tenga en cuenta y así poder tener una mejor organización para tener un menú variado en el día a día.</p>
    </header>

    <div class="container">
        <!-- Título de la página de inicio de sesión -->
        <h2>Iniciar Sesión</h2>
        <!-- Formulario de inicio de sesión que se envía mediante el método POST -->
        <form method="POST">
            <!-- Campo de texto para ingresar el nombre de usuario -->
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <!-- Campo de texto para ingresar la contraseña -->
            <input type="password" name="password" placeholder="Contraseña" required>
            <!-- Si hay un error, se muestra un mensaje en rojo -->
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn-blue">Iniciar sesión</button>
        </form>
        <!-- Enlace para agregar un nuevo usuario (redirecciona a 'add_user.php') -->
        <a href="add_user.php" class="btn-green">Agregar usuario</a>
    </div>

    <footer style="margin-top: 30px; text-align: center;">
    <!-- Video incrustado -->
    <div style="margin-bottom: 20px;">
        <iframe width="300" height="170"
            src="https://www.youtube.com/embed/Y_K5poVTHek"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    </div>

    <!-- Enlaces con íconos -->
    <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; align-items: center;">
        <a href="https://railway.app" target="_blank" title="Railway">
            <img src="https://railway.app/brand/logo-dark.svg" alt="Railway" style="height: 32px;">
        </a>

        <a href="https://render.com" target="_blank" title="Render">
    <img src="https://avatars.githubusercontent.com/u/36424661?s=200&v=4" alt="Render" style="height: 28px; border-radius: 5px;">
</a>
<a href="https://northflank.com" target="_blank" title="Northflank">
    <img src="https://avatars.githubusercontent.com/u/69378842?s=200&v=4" alt="Northflank" style="height: 28px; border-radius: 5px;">
</a>
<a href="https://fly.io" target="_blank" title="Fly.io">
    <img src="https://avatars.githubusercontent.com/u/6752317?s=200&v=4" alt="Fly.io" style="height: 28px; border-radius: 5px;">
</a>


        <a href="https://vercel.com" target="_blank" title="Vercel">
            <img src="https://assets.vercel.com/image/upload/front/favicon/vercel/152x152.png" alt="Vercel" style="height: 28px;">
        </a>
        <a href="https://netlify.com" target="_blank" title="Netlify">
            <img src="https://www.netlify.com/v3/img/components/logomark.png" alt="Netlify" style="height: 28px;">
        </a>
        <a href="https://deta.space" target="_blank" title="Deta">
            <img src="https://avatars.githubusercontent.com/u/47602532?s=200&v=4" alt="Deta" style="height: 28px; border-radius: 5px;">
        </a>
    </div>
</footer>

</body>
</html>

<style>
    /* Estilos generales para la página */

    body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    /*Centrado flexbox */
    display: flex;
    flex-direction: column;
    align-items: center;
    
}


    /* Estilos para el contenedor del formulario */
    .container {
        background-color: white; /* Fondo blanco para el contenedor */
        padding: 30px; /* Espaciado interno */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        width: 300px; /* Ancho fijo */
        max-width: 90%; 
        text-align: center; /* Centra el texto dentro del contenedor */
        margin: 20px auto;
        margin-top: 20px; /* Empuja el formulario hacia abajo para dejar espacio al header */
    }

    h2 {
        margin-bottom: 20px; /* Espaciado debajo del título */
        color: #333; /* Color de texto oscuro */
    }

    /* Estilos para los campos de texto */
    input[type="text"], input[type="password"] {
        width: 100%; /* Hace que los campos ocupen todo el ancho disponible */
        padding: 10px; /* Espaciado interno dentro del campo */
        margin: 10px 0; /* Espaciado vertical entre los campos */
        border: 1px solid #ddd; /* Borde gris claro */
        border-radius: 5px; /* Bordes redondeados */
        font-size: 16px; /* Tamaño de fuente */
        box-sizing: border-box; /* Incluye el padding y borde en el ancho total */
    }

    /* Estilos para los botones */
    button, .btn-green, .btn-blue {
        width: 100%; /* Hace que los botones ocupen todo el ancho disponible */
        padding: 12px; /* Espaciado interno dentro de los botones */
        margin: 10px 0; /* Espaciado vertical entre los botones */
        border: none; /* Elimina el borde predeterminado */
        border-radius: 5px; /* Bordes redondeados */
        font-size: 16px; /* Tamaño de fuente */
        cursor: pointer; /* Cambia el cursor a mano al pasar sobre el botón */
        transition: background-color 0.3s ease; /* Suaviza el cambio de color al pasar el mouse */
    }

    /* Estilo para el botón de inicio de sesión (color azul) */
    .btn-blue {
        background-color: #007bff; /* Color de fondo azul */
        color: white; /* Color del texto blanco */
    }

    /* Efecto al pasar el mouse sobre el botón azul */
    .btn-blue:hover {
        background-color: #0056b3; /* Cambio de color a un azul más oscuro */
    }

    /* Estilo para el botón de 'Agregar usuario' (color verde) */
    .btn-green {
        background-color: #28a745; /* Color de fondo verde */
        color: white; /* Color del texto blanco */
        text-decoration: none; /* Elimina el subrayado del enlace */
    }

    /* Efecto al pasar el mouse sobre el botón verde */
    .btn-green:hover {
        background-color: #218838; /* Cambio de color a un verde más oscuro */
    }

    /* Estilo para el mensaje de error */
    .error {
        color: red; /* Color del texto rojo */
        font-size: 14px; /* Tamaño de fuente pequeño */
        margin-top: 10px; /* Espaciado superior para separar del formulario */
    }

    /* Repetición de estilos para los botones con más espaciado */
    button, .btn-green, .btn-blue {
        width: 100%; /* Hace que los botones ocupen todo el ancho disponible */
        padding: 12px; /* Espaciado interno dentro de los botones */
        margin: 15px 0;  /* Aumenta el espacio vertical entre los botones */
        border: none; /* Elimina el borde predeterminado */
        border-radius: 5px; /* Bordes redondeados */
        font-size: 16px; /* Tamaño de fuente */
        cursor: pointer; /* Cambia el cursor a mano al pasar sobre el botón */
        transition: background-color 0.3s ease; /* Suaviza el cambio de color al pasar el mouse */
    }

    html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}



footer {
    margin-top: auto;
    padding: 20px;
    background-color: #f1f1f1;
    width: 100%;
}

/* Estilo para el encabezado principal */
.main-header {
    text-align: center;
    padding: 50px 20px 10px 20px; /* más espacio arriba */
    background-color: yellow;
    border-bottom: 1px solid #ddd;
    width: 100%; /* ocupa todo el ancho */
    box-sizing: border-box; /* asegura que padding no afecte el ancho */
    
}


.main-header h1 {
    margin: 0;
    margin-top: 20px;
    font-size: 2rem;
    color: black;
}

.main-header p {
    margin-top: 10px;
    font-size: 1rem;
    color: black;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }

    .container {
        width: 100%;
        box-sizing: border-box;
        padding: 20px;
    }

    .main-header h1 {
        font-size: 1.5rem;
    }

    .main-header p {
        font-size: 0.95rem;
    }

    footer iframe {
        width: 100%;
        height: auto;
    }
}



</style>


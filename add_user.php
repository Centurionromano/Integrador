<?php
// Inicia una nueva sesión o reanuda la sesión existente.
session_start();

// Incluye el archivo 'db.php' que se asume contiene la conexión a la base de datos.
include('db.php');

// Verifica si la solicitud es de tipo POST, es decir, si se envió un formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene el valor del campo 'username' del formulario.
    $username = $_POST['username'];

    // Obtiene el valor del campo 'password' del formulario.
    $password = $_POST['password'];

    // Cifra la contraseña utilizando el algoritmo 'PASSWORD_DEFAULT' (bcrypt, por defecto).
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepara una consulta SQL para insertar el nuevo usuario en la base de datos.
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

    // Ejecuta la consulta SQL, pasando los valores del nombre de usuario y la contraseña cifrada.
    $stmt->execute(['username' => $username, 'password' => $hashed_password]);

    // Redirige al usuario a la página 'index.php' después de crear el nuevo usuario.
    header('Location: index.php');

    // Termina el script para evitar que se ejecute cualquier código adicional después de la redirección.
    exit();
}
?>

<!-- Inicia el documento HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Define la codificación de caracteres del documento como UTF-8 -->
    <meta charset="UTF-8">
    
    <!-- Define el título de la página que aparecerá en la pestaña del navegador -->
    <title>Agregar Usuario</title>
    
</head>
<body>
    <!-- Contenedor principal donde se encuentra el formulario -->
    <div class="container">
        <!-- Título de la página o formulario -->
        <h2>Crear Nuevo Usuario</h2>
        
        <!-- Formulario que enviará los datos al servidor por método POST -->
        <form method="POST">
            <!-- Campo de texto para ingresar el nombre de usuario -->
            <input type="text" name="username" placeholder="Nombre de usuario" required>

            <!-- Campo de contraseña para ingresar la clave -->
            <input type="password" name="password" placeholder="Contraseña" required>
            
            <!-- Contenedor para los botones de acción -->
            <div class="buttons">
                <!-- Botón para enviar el formulario -->
                <button type="submit" class="btn-primary">Crear Usuario</button>

                <!-- Enlace para cancelar y regresar a la página 'index.php' -->
                <a href="index.php" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Estilos CSS para el diseño de la página -->
    <style>
    /* Define el estilo global del cuerpo de la página */
    body {
        font-family: Arial, sans-serif; /* Establece la tipografía para todo el documento */
        background-color: #f4f4f4; /* Define un color de fondo gris claro */
        margin: 0; /* Elimina los márgenes por defecto */
        padding: 0; /* Elimina el padding por defecto */
    }

    /* Define el estilo para el contenedor del formulario */
    .container {
        width: 300px; /* Define un ancho fijo para el contenedor */
        margin: 50px auto; /* Centra el contenedor horizontalmente y le da un margen superior */
        padding: 20px; /* Añade espacio interior dentro del contenedor */
        background-color: #fff; /* Establece el fondo blanco para el formulario */
        border-radius: 8px; /* Redondea las esquinas del contenedor */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Añade una sombra sutil al contenedor */
    }

    /* Estilo para el título de la página (h2) */
    h2 {
        text-align: center; /* Centra el texto del título */
        color: #333; /* Define el color del texto como gris oscuro */
    }

    /* Estilo para los campos de entrada de texto */
    input {
        width: 100%; /* Hace que los campos de entrada ocupen todo el ancho disponible */
        padding: 10px; /* Añade relleno interior a los campos */
        margin: 10px 0; /* Añade margen vertical entre los campos */
        border: 1px solid #ddd; /* Añade un borde gris claro */
        border-radius: 4px; /* Redondea las esquinas de los campos */
        font-size: 16px; /* Define el tamaño de la fuente dentro de los campos */
        box-sizing: border-box; /* Incluye el padding en el cálculo del ancho total */
    }

    /* Estilo para el contenedor de los botones */
    .buttons {
        display: flex; /* Usa flexbox para alinear los elementos en fila */
        justify-content: space-between; /* Distribuye los botones de manera equidistante */
        margin-top: 20px; /* Añade un margen superior a los botones */
    }

    /* Estilo para el botón principal (Crear Usuario) */
    .btn-primary {
        background-color: #4CAF50; /* Define el color de fondo verde */
        color: white; /* Define el color del texto como blanco */
        border: none; /* Elimina el borde del botón */
        padding: 10px 20px; /* Añade relleno alrededor del texto */
        font-size: 16px; /* Define el tamaño de la fuente */
        border-radius: 4px; /* Redondea las esquinas del botón */
        cursor: pointer; /* Cambia el cursor a una mano cuando pasa sobre el botón */
        transition: background-color 0.3s ease; /* Añade una transición suave al cambiar el color de fondo */
    }

    /* Estilo para cuando el usuario pasa el cursor sobre el botón Crear Usuario */
    .btn-primary:hover {
        background-color: #45a049; /* Cambia el color de fondo a un verde más oscuro cuando se pasa el cursor */
    }

    /* Estilo para el botón de cancelar (Volver a la página de inicio) */
    .btn-cancel {
        background-color: #f44336; /* Define el color de fondo rojo */
        color: white; /* Define el color del texto como blanco */
        padding: 10px 20px; /* Añade relleno alrededor del texto */
        font-size: 16px; /* Define el tamaño de la fuente */
        border-radius: 4px; /* Redondea las esquinas del botón */
        text-decoration: none; /* Elimina el subrayado del enlace */
        display: inline-block; /* Permite aplicar estilo de bloque a un enlace */
        transition: background-color 0.3s ease; /* Añade una transición suave al cambiar el color de fondo */
    }

    /* Estilo para cuando el usuario pasa el cursor sobre el botón Cancelar */
    .btn-cancel:hover {
        background-color: #e53935; /* Cambia el color de fondo a un rojo más oscuro cuando se pasa el cursor */
    }
</style>

</body>
</html>

<?php
session_start(); // Inicia una sesión o reanuda la sesión actual
include('db.php'); // Incluye el archivo de conexión a la base de datos

// Verifica si el usuario está autenticado, si no redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirige al usuario a la página de login
    exit(); // Termina la ejecución del script
}

// Verifica si la solicitud es de tipo POST (cuando se envía el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; // Obtiene el nombre de la receta del formulario
    $image_url = ''; // Inicializa la variable para la URL de la imagen (vacía por defecto)
    $type = $_POST['type']; // Obtiene el tipo de receta (desayuno, comida, cena, postre)
    $ingredients = $_POST['ingredients']; // Obtiene los ingredientes de la receta
    $instructions = $_POST['instructions']; // Obtiene las instrucciones de la receta

    // Subir la imagen si se seleccionó una
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name']; // Nombre original del archivo de imagen
        $image_tmp_name = $_FILES['image']['tmp_name']; // Ruta temporal del archivo en el servidor
        $image_size = $_FILES['image']['size']; // Tamaño del archivo de la imagen
        $image_type = $_FILES['image']['type']; // Tipo MIME de la imagen (ejemplo: image/jpeg)

        // Directorio donde se almacenarán las imágenes subidas
        $upload_dir = 'images/';
        $image_path = $upload_dir . basename($image_name); // Ruta completa para guardar la imagen

        // Validación del tipo de archivo de la imagen
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Tipos de imagen permitidos
        if (in_array($image_type, $allowed_types)) { // Si el tipo de la imagen es válido
            // Mueve el archivo subido desde la ubicación temporal al directorio destino
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $image_url = $image_path; // Si la imagen se sube correctamente, se asigna la ruta a la variable $image_url
            } else {
                echo "Error al subir la imagen."; // Mensaje de error si no se puede mover el archivo
                exit(); // Termina la ejecución si no se puede subir la imagen
            }
        } else {
            echo "Solo se permiten imágenes JPEG, PNG o GIF."; // Mensaje si el tipo de imagen no es permitido
            exit(); // Termina la ejecución si el tipo de archivo no es válido
        }
    }

    // Inserta la receta en la base de datos
    $stmt = $pdo->prepare(
        "INSERT INTO recipes (name, image_url, type, ingredients, instructions) 
         VALUES (:name, :image_url, :type, :ingredients, :instructions)"
    ); // Prepara la sentencia SQL para insertar los datos
    $stmt->execute([
        'name' => $name, // Asocia el valor de 'name' al parámetro :name
        'image_url' => $image_url, // Asocia el valor de 'image_url' al parámetro :image_url
        'type' => $type, // Asocia el valor de 'type' al parámetro :type
        'ingredients' => $ingredients, // Asocia el valor de 'ingredients' al parámetro :ingredients
        'instructions' => $instructions // Asocia el valor de 'instructions' al parámetro :instructions
    ]);

    header('Location: recipes.php?added=true'); // Redirige a la página de recetas con un parámetro para confirmar que se añadió la receta
    exit(); // Termina la ejecución del script
}
?>

<!-- El código HTML para mostrar el formulario de añadir receta -->

<!DOCTYPE html>
<html lang="es"> <!-- Define el idioma de la página como español -->
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <title>Añadir Receta</title> <!-- Título de la página -->
    <link rel="stylesheet" href="css/style.css"> <!-- Enlaza con el archivo CSS externo para los estilos -->
</head>
<body>
    <div class="container"> <!-- Contenedor principal del formulario -->
        <h2>Añadir Nueva Receta</h2> <!-- Título principal del formulario -->
        <form method="POST" enctype="multipart/form-data"> <!-- Formulario para enviar los datos por POST y permitir la carga de archivos -->
            <input type="text" name="name" placeholder="Nombre de la receta" required> <!-- Campo de texto para el nombre de la receta -->
            <input type="file" name="image" accept="image/jpeg, image/png, image/gif" required> <!-- Campo para subir la imagen (solo imágenes permitidas) -->
            <select name="type" required> <!-- Menú desplegable para elegir el tipo de receta -->
                <option value="desayuno">Desayuno</option> <!-- Opción de desayuno -->
                <option value="comida">Comida</option> <!-- Opción de comida -->
                <option value="cena">Cena</option> <!-- Opción de cena -->
                <option value="postre">Postre</option> <!-- Opción de postre -->
            </select>
            <textarea name="ingredients" placeholder="Ingredientes" required></textarea> <!-- Campo de texto para los ingredientes -->
            <textarea name="instructions" placeholder="Instrucciones" required></textarea> <!-- Campo de texto para las instrucciones -->
            <button type="submit">Añadir Receta</button> <!-- Botón para enviar el formulario -->
            <a href="recipes.php" class="btn-cancel">Cancelar</a> <!-- Enlace para cancelar y volver a la página de recetas -->
        </form>
    </div>

    <style> /*Estilos internos para la página */
    body {
        font-family: Arial, sans-serif; /* Define la fuente para el cuerpo */
        background-color: #f4f4f4; /* Color de fondo claro para el cuerpo */
        margin: 0; /* Elimina los márgenes */
        padding: 0; /* Elimina el padding */
    }

    .container {
        width: 70%; /* Ancho del contenedor principal ajustado al 70% de la página */
        margin: 50px auto; /* Centra el contenedor en la página con un margen superior de 50px */
        padding: 20px; /* Relleno interno del contenedor */
        background-color: #fff; /* Color de fondo blanco para el contenedor */
        border-radius: 8px; /* Bordes redondeados para el contenedor */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil alrededor del contenedor */
    }
    h2 {
        text-align: center; /* Centra el texto del encabezado */
        color: #333; /* Color oscuro para el texto */
    }
    input, select, textarea {
        width: 100%; /* Hace que los campos ocupen el 100% del ancho disponible */
        padding: 10px; /* Agrega padding dentro de los campos */
        margin: 10px 0; /* Agrega un margen de 10px arriba y abajo de cada campo */
        border: 1px solid #ddd; /* Establece un borde gris claro para los campos */
        border-radius: 4px; /* Bordes redondeados para los campos */
        font-size: 16px; /* Tamaño de fuente de 16px */
        box-sizing: border-box; /* Asegura que el padding y el borde no afecten el ancho total */
    }
    textarea {
        min-height: 100px; /* Establece una altura mínima para los cuadros de texto */
        height: 400px; /* Altura fija de 400px para los campos de ingredientes e instrucciones */
        resize: vertical; /* Permite que los usuarios redimensionen el campo verticalmente */
    }
    select {
        padding: 10px; /* Padding dentro del campo select */
        background-color: #fff; /* Fondo blanco para el select */
        border: 1px solid #ddd; /* Borde gris claro */
        border-radius: 4px; /* Bordes redondeados */
    }
    .buttons {
        display: flex; /* Usa Flexbox para organizar los botones */
        justify-content: space-between; /* Distribuye los botones a los extremos */
        margin-top: 20px; /* Margen superior de 20px */
    }
    .btn-primary {
        background-color: #4CAF50; /* Color de fondo verde para el botón */
        color: white; /* Color del texto blanco */
        border: none; /* Sin borde */
        padding: 10px 20px; /* Padding de 10px arriba y abajo, 20px a los lados */
        font-size: 16px; /* Tamaño de fuente de 16px */
        border-radius: 4px; /* Bordes redondeados */
        cursor: pointer; /* Cambia el cursor al pasar por encima */
        transition: background-color 0.3s ease; /* Efecto de transición suave para el cambio de color */
    }
    .btn-primary:hover {
        background-color: #45a049; /* Cambio de color cuando el cursor pasa sobre el botón */
    }
    .btn-cancel {
        background-color: #f44336; /* Color de fondo rojo para el botón de cancelar */
        color: white; /* Texto blanco */
        padding: 10px 20px; /* Padding dentro del botón */
        font-size: 16px; /* Tamaño de fuente de 16px */
        border-radius: 4px; /* Bordes redondeados */
        text-decoration: none; /* Elimina la decoración de texto (subrayado) */
        display: inline-block; /* Asegura que el enlace se comporte como un bloque en línea */
        transition: background-color 0.3s ease; /* Efecto de transición para el color de fondo */
    }
    .btn-cancel:hover {
        background-color: #e53935; /* Cambio de color cuando el cursor pasa sobre el botón */
    }
</style>

</body>
</html>   

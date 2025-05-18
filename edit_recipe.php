<?php
// Inicia una sesión PHP para poder utilizar variables de sesión
session_start();

// Incluye el archivo de conexión a la base de datos
include('db.php');

// Verificar si el usuario está logueado, si no, redirigir a la página de recetas
if (!isset($_SESSION['user_id'])) {
  // Redirige a la página de recetas con el parámetro 'modified=true'
  header('Location: recipes.php?modified=true');
  exit(); // Termina el script después de la redirección
}

// Verificar si se pasa un ID a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtener el ID de la receta desde la URL

    // Preparar una consulta SQL para obtener la receta por su ID
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $stmt->execute(['id' => $id]); // Ejecutar la consulta con el ID de la receta
    $recipe = $stmt->fetch(); // Obtener los datos de la receta

    // Verificar si la receta existe
    if (!$recipe) {
        // Si no se encuentra la receta, redirigir a la página de recetas
        header('Location: recipes.php');
        exit(); // Termina el script después de la redirección
    }

    // Verificar si el formulario fue enviado por método POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos del formulario
        $name = $_POST['name']; // Nombre de la receta
        $image_url = $recipe['image_url']; // Usar la imagen actual si no se sube una nueva
        $type = $_POST['type']; // Tipo de receta (desayuno, comida, cena, etc.)
        $ingredients = $_POST['ingredients']; // Ingredientes de la receta
        $instructions = $_POST['instructions']; // Instrucciones de la receta

        // Verificar si se ha subido una nueva imagen
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Obtener información del archivo subido
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];
            $upload_dir = 'images/'; // Directorio donde se guardarán las imágenes
            $image_path = $upload_dir . basename($image_name); // Ruta donde se guardará la imagen

            // Validar el tipo de imagen (solo se permiten imágenes JPEG, PNG o GIF)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($image_type, $allowed_types)) {
                // Verificar si la imagen ya existe en el directorio
                if (!file_exists($image_path)) {
                    // Si la imagen no existe, moverla al directorio de imágenes
                    if (move_uploaded_file($image_tmp_name, $image_path)) {
                        $image_url = $image_path; // Actualizar la URL de la imagen
                    }
                } else {
                    // Si ya existe la imagen, conservar la URL de la imagen actual
                    $image_url = $recipe['image_url'];
                }
            }
        }

        // Preparar y ejecutar una consulta SQL para actualizar los datos de la receta
        $stmt = $pdo->prepare(
            "UPDATE recipes SET name = :name, image_url = :image_url, type = :type, ingredients = :ingredients, instructions = :instructions WHERE id = :id"
        );
        $stmt->execute([
            'name' => $name,
            'image_url' => $image_url, // Se actualiza la URL de la imagen (puede ser la nueva o la antigua)
            'type' => $type,
            'ingredients' => $ingredients,
            'instructions' => $instructions,
            'id' => $id // Usamos el ID de la receta para identificar cuál actualizar
        ]);

         // Después de actualizar, redirigir a la página de recetas con el parámetro 'modified=true' 
         // para indicar que los cambios se realizaron correctamente
        header('Location: recipes.php?modified=true');
        exit(); // Termina el script después de la redirección
    }
} 

?>

<!-- Aquí empieza el código HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Establece el tipo de codificación de caracteres -->
    <title>Editar Receta</title> <!-- Título de la página -->
    <link rel="stylesheet" href="css/style.css"> <!-- Vincula una hoja de estilo externa -->
</head>
<body>
    <div class="container"> <!-- Contenedor principal del formulario -->
        <h2>Editar Receta</h2> <!-- Título principal de la página -->
        <form method="POST" enctype="multipart/form-data"> <!-- Formulario con método POST y soporte para archivos -->
            <!-- Campo para el nombre de la receta -->
            <input type="text" name="name" value="<?php echo htmlspecialchars($recipe['name']); ?>" required> <!-- Muestra el nombre de la receta actual -->

            <!-- Campo para subir una nueva imagen -->
            <input type="file" name="image" accept="image/jpeg, image/png, image/gif"> <!-- Permite seleccionar una nueva imagen -->
            <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" alt="Imagen actual" width="100"> <!-- Muestra la imagen actual de la receta -->

            <!-- Campo para seleccionar el tipo de receta -->
            <select name="type" required>
                <option value="desayuno" <?php echo $recipe['type'] == 'desayuno' ? 'selected' : ''; ?>>Desayuno</option>
                <option value="comida" <?php echo $recipe['type'] == 'comida' ? 'selected' : ''; ?>>Comida</option>
                <option value="cena" <?php echo $recipe['type'] == 'cena' ? 'selected' : ''; ?>>Cena</option>
                <option value="postre" <?php echo $recipe['type'] == 'postre' ? 'selected' : ''; ?>>Postre</option>
            </select>

            <!-- Campo para los ingredientes -->
            <textarea name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>

            <!-- Campo para las instrucciones -->
            <textarea name="instructions" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>

            <!-- Botón para guardar los cambios -->
            <button type="submit">Guardar Cambios</button>
            <!-- Enlace para cancelar y volver a la página de recetas -->
            <a href="recipes.php" class="btn-cancel">Cancelar</a>
        </form>
    </div>

    <!-- Estilos CSS específicos para esta página -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Tipo de letra para todo el cuerpo */
            background-color: #f4f4f4; /* Color de fondo */
            margin: 0; /* Elimina los márgenes por defecto */
            padding: 0; /* Elimina el padding por defecto */
        }
        .container {
            width: 70%; /* Ancho del formulario */
            margin: 50px auto; /* Centra el formulario en la página */
            padding: 20px; /* Relleno alrededor del formulario */
            background-color: #fff; /* Color de fondo del formulario */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil para darle profundidad */
        }
        h2 {
            text-align: center; /* Centra el título */
            color: #333; /* Color del título */
        }
        input, select, textarea {
            width: 100%; /* Hace que los campos ocupen todo el ancho disponible */
            padding: 10px; /* Añade espacio dentro de los campos */
            margin: 10px 0; /* Espacio entre los campos */
            border: 1px solid #ddd; /* Borde sutil */
            border-radius: 4px; /* Bordes redondeados */
            font-size: 16px; /* Tamaño de la fuente */
            box-sizing: border-box; /* Hace que el padding y border se incluyan en el tamaño total */
        }
        textarea {
            min-height: 100px; /* Altura mínima para el área de texto */
            height: 400px; /* Altura fija para las instrucciones */
            resize: vertical; /* Permite redimensionar el área de texto solo verticalmente */
        }
        select {
            padding: 10px; /* Añadir padding en el select */
            background-color: #fff; /* Fondo blanco para el select */
            border: 1px solid #ddd; /* Borde sutil */
            border-radius: 4px; /* Bordes redondeados */
        }
        .buttons {
            display: flex; /* Usar flexbox para distribuir los botones */
            justify-content: space-between; /* Espaciado entre los botones */
            margin-top: 20px; /* Espacio arriba de los botones */
        }
        .btn-primary {
            background-color: #4CAF50; /* Color verde para el botón de guardar */
            color: white; /* Texto blanco */
            border: none; /* Sin borde */
            padding: 10px 20px; /* Padding interno */
            font-size: 16px; /* Tamaño de fuente */
            border-radius: 4px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor al pasar por encima */
            transition: background-color 0.3s ease; /* Transición suave en el color de fondo */
        }
        .btn-primary:hover {
            background-color: #45a049; /* Cambia el color al pasar el ratón sobre el botón */
        }
        .btn-cancel {
            background-color: #f44336; /* Color rojo para el botón de cancelar */
            color: white; /* Texto blanco */
            padding: 10px 20px; /* Padding interno */
            font-size: 16px; /* Tamaño de fuente */
            border-radius: 4px; /* Bordes redondeados */
            text-decoration: none; /* Elimina subrayado */
            display: inline-block; /* Hace que el enlace se vea como un botón */
            transition: background-color 0.3s ease; /* Transición suave en el color de fondo */
        }
        .btn-cancel:hover {
            background-color: #e53935; /* Cambia el color al pasar el ratón sobre el botón */
        }
    </style>
</body>
</html>




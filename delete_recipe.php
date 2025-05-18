<?php
// Inicia la sesión de PHP, permitiendo el acceso a las variables de sesión
session_start();

// Incluye el archivo de conexión a la base de datos (se asume que 'db.php' contiene la configuración de conexión)
include('db.php');

// Verificar si el usuario está autenticado, revisando si existe un 'user_id' en la sesión
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está autenticado, redirige a la página de login
    header('Location: login.php');
    exit(); // Detiene la ejecución del script para evitar continuar con el código
}

// Verificar si se ha pasado el parámetro 'id' por la URL (GET)
if (isset($_GET['id'])) {
    // Si el parámetro 'id' está presente, se guarda en la variable $id
    $id = $_GET['id'];

    // Preparar una consulta SQL para eliminar la receta de la base de datos usando el ID proporcionado
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
    
    // Ejecutar la consulta, pasando el valor de $id como parámetro para eliminar la receta correspondiente
    $stmt->execute([$id]);

    // Después de eliminar la receta, redirigir al usuario de vuelta a 'recipes.php' con un parámetro 'deleted=true'
    // Esto puede servir para mostrar un mensaje de éxito al usuario
    header('Location: recipes.php?deleted=true');
    exit(); // Detiene la ejecución para asegurar que la redirección se haga inmediatamente
}
?>



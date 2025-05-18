<?php
// Configuración de la base de datos
$host = 'localhost';          // El servidor de base de datos (por lo general localhost)
$dbname = 'my_project_db';    // Nombre de la base de datos (aquí se especifica la base de datos que se va a utilizar)
$username = 'root';           // Nombre de usuario de la base de datos (en XAMPP suele ser 'root')
$password = '';               // Contraseña de la base de datos (en XAMPP suele estar vacía)


// Crear una conexión PDO
try {
    // Intentar crear una conexión PDO utilizando los datos de configuración anteriores
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);  // Se crea una instancia de PDO usando MySQL como gestor de base de datos

    // Configurar el modo de error para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Configura PDO para que, en caso de errores, lance excepciones en lugar de errores normales

} catch (PDOException $e) {
    // Si ocurre un error al conectar, mostrarlo
    die("Error al conectar a la base de datos: " . $e->getMessage());  // Si ocurre una excepción (error), se captura y se muestra un mensaje con la descripción del error
}
?>


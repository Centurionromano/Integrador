<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

// Incluye el archivo que contiene la conexión a la base de datos
include('db.php');

// Verificar si el usuario está logueado comprobando si 'user_id' existe en la sesión
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está logueado, se devuelve un mensaje de error en formato JSON
    echo json_encode(['status' => 'error', 'message' => 'Usuario no logueado']);
    exit();  // Finaliza la ejecución del script
}

// Número de recetas a mostrar por página
$recipes_per_page = 7;

// Obtener el número de página actual desde la URL, por defecto es 1 si no está especificado
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcular el punto de inicio para la paginación (cuántas recetas se deben omitir)
$start_from = ($page - 1) * $recipes_per_page;

// Obtener la columna de ordenamiento desde la URL, por defecto es 'id'
$order_column = isset($_GET['order_column']) ? $_GET['order_column'] : 'id';

// Obtener la dirección de ordenamiento desde la URL, por defecto es 'ASC' (ascendente)
$order_direction = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'ASC';

// Cambiar la dirección del ordenamiento. Si es 'ASC' lo cambiamos a 'DESC', y viceversa.
if ($order_direction == 'ASC') {
    $order_direction = 'DESC';
} else {
    $order_direction = 'ASC';
}

// Para la búsqueda: Si se recibe una consulta de búsqueda, la envolvemos con '%' para usar en LIKE
$search_query = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

// Contar el total de recetas que coinciden con la búsqueda (sin paginación)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM recipes WHERE name LIKE :search_query OR ingredients LIKE :search_query OR instructions LIKE :search_query");

// Asociar el parámetro de búsqueda a la consulta
$stmt->bindParam(':search_query', $search_query, PDO::PARAM_STR);

// Ejecutar la consulta para obtener el número total de recetas
$stmt->execute();

// Obtener el total de recetas encontradas
$total_recipes = $stmt->fetchColumn();

// Calcular el número total de páginas (paginación)
$total_pages = ceil($total_recipes / $recipes_per_page);

// Obtener las recetas de la base de datos, con los parámetros de búsqueda, orden y paginación
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE name LIKE :search_query OR ingredients LIKE :search_query OR instructions LIKE :search_query ORDER BY $order_column $order_direction LIMIT :start_from, :recipes_per_page");

// Asociar los parámetros de búsqueda, inicio y límite de resultados
$stmt->bindParam(':search_query', $search_query, PDO::PARAM_STR);
$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindParam(':recipes_per_page', $recipes_per_page, PDO::PARAM_INT);

// Ejecutar la consulta para obtener las recetas
$stmt->execute();

// Recuperar todas las recetas en un arreglo asociativo
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver las recetas y la información de la paginación en formato JSON, incluyendo el total de recetas
echo json_encode([
    'recipes' => $recipes,  // Recetas obtenidas
    'total_pages' => $total_pages,  // Número total de páginas
    'current_page' => $page,  // Página actual
    'total_entries' => $total_recipes // Total de recetas encontradas
]);
?>

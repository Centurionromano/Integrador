<?php
// Inicia una nueva sesión o reanuda una sesión existente.
session_start();

// Destruye todos los datos asociados con la sesión actual.
session_destroy();

// Redirige al usuario a la página "index.php" después de destruir la sesión.
header('Location: index.php');

// Detiene la ejecución del script para asegurarse de que no se ejecute más código después de la redirección.
exit();
?>

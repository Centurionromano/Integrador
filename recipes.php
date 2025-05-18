<?php
session_start(); // Inicia una sesión PHP para manejar variables globales entre páginas
include('db.php'); // Incluye el archivo de conexión a la base de datos

// Verificar si el usuario está autenticado (si no hay un 'user_id' en la sesión, redirige a la página de login)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirige a login si el usuario no está autenticado
    exit(); // Termina la ejecución del script para evitar que se cargue la página
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Recetas</title> <!-- Título de la página -->
    <link rel="stylesheet" href="css/style.css"> <!-- Vincula el archivo CSS para los estilos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Carga jQuery desde un CDN -->
    <style>

         /*Mismo tamaño de letra  */
         html {
  -webkit-text-size-adjust: 100%;  /* iOS Safari */
  -ms-text-size-adjust: 100%;      /* IE Mobile */ }

/* */


        /* Estilo para los botones */
        .edit-btn {
            background-color: #007bff; /* Azul para editar */
            color: white; 
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn {
            background-color: #dc3545; /* Rojo para eliminar */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .add-btn {
            background-color: #28a745; /* Verde para añadir receta */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px; /* Separar de la tabla */
            display: inline-block;
        }

        .logout-btn {
            background-color: #dc3545; /* Rojo para salir */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px; /* Separar de la tabla */
            display: inline-block;
        }

        /* Paginación */
        .pagination {
            margin-top: 20px; /* Separar de la tabla */
        }

        .pagination a {
            padding: 6px 12px;
            margin: 0 4px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
        }

        /* Barra de búsqueda */
        #search {
            margin-bottom: 20px; /* Separar la barra de búsqueda de la tabla */
        }

        /* Contenedor de la página */
        .container {
            padding: 20px;
        }

        /* Contenedor para los botones */
        .button-container {
            display: flex;
            gap: 10px; /* Espacio entre los botones */
            justify-content: flex-start; /* Alinea los botones a la izquierda */
        }

        /* Ajuste del margen para los botones de editar y eliminar */
        .edit-btn, .delete-btn {
            margin-bottom: 0; /* Elimina márgenes innecesarios en la parte inferior de los botones */
        }

        /* Estilo para las flechas */
        .sort-arrow {
            cursor: pointer;
            margin-left: 5px;
        }

        /* Estilo para la animación de fade-in */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }





        /* Clase que aplica el fade-in a la tabla */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* justo después  de table.fade-in */
table, th, td {
  font-size: 1rem;     /* o 16px, lo que estés usando en tu body */
  
}




        /* Estilo para el contador en la esquina superior derecha */
        .entry-counter {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Estilo para el modal */
        .modal {
            display: none; /* Por defecto el modal está oculto */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            text-align: center;
            width: 300px;
        }

        .modal .modal-message {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .modal .close-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal.show {
            display: block; /* Mostrar el modal cuando tenga la clase 'show' */
        }

        /* Estilo para el mensaje de éxito */
        .success-message {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        /*Estilos para el modal de éxito */
        .modal.show {
            display: block;
            animation: fadeIn 0.5s ease-out;
        }

        .modal-message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #28a745; /* Verde para indicar éxito */
        }

        .close-btn {
            background-color: #007bff; /* Azul para el botón de cerrar */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .close-btn:hover {
            background-color: #0056b3;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            text-align: center;
            width: 300px;
            max-width: 90%;
        }

        /* 1) Scroll horizontal si hace falta */
.table-responsive {
  width: 100%;
  overflow-x: auto;
  margin-bottom: 20px;
}

/* 2) Diseño fijo para la tabla */
.table-responsive table {
  width: 100%;
  border-collapse: collapse;
  table-layout: auto;
}

/* 3) Celdas con ajuste de palabra y fuente unificada */
.table-responsive th,
.table-responsive td {
  padding: 8px;
  font-size: 0.85rem;       /* letra más pequeña */
  word-break: normal;       /* deja que las palabras se rompan solo al final de línea */
  white-space: normal;      /* evita saltos automáticos dentro de palabras */
  text-align: left;
}


/* 4) Botones flexibles: en móvil apilan si no caben */
.button-container {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

/* 5) Reduce padding/font en móviles */
@media (max-width: 768px) {
  body .container {
    padding: 10px;
  }

  .table-responsive th,
  .table-responsive td {
    padding: 6px;
    font-size: 0.75rem;
  }

  .add-btn,
  .logout-btn,
  .edit-btn,
  .delete-btn {
    padding: 6px 12px;
    font-size: 0.9rem;
  }

  /* Centrar el contador y buscar en dos líneas si es muy angosto */
  #search,
  .entry-counter {
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 10px;
  }

  .pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: center;
  }

  .pagination a {
    padding: 4px 8px;
    font-size: 0.85rem;
  }
}

    </style>


</head>
<body>
    <div class="container">
        <h2>Recetas</h2>

        <!-- Mensaje de éxito si la receta fue añadida -->
        <?php if (isset($_GET['added']) && $_GET['added'] == 'true'): ?>
        <div class="modal show" id="success-modal-added">
            <div class="modal-message">Se añadió receta con éxito.</div>
            <button class="close-btn" id="close-success-modal-added">Cerrar</button>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['modified']) && $_GET['modified'] == 'true'): ?>
        <div class="modal show" id="success-modal-modified">
            <div class="modal-message">Se modificó la receta con éxito.</div>
            <button class="close-btn" id="close-success-modal-modified">Cerrar</button>
        </div>
        <?php endif; ?>

        <!-- Barra de búsqueda -->
        <input type="text" id="search" placeholder="Buscar receta...">

        <!-- Contador de entradas -->
        <div class="entry-counter" id="entry-counter">0 Entradas</div>

        <!-- Modificaciones resonsive  -->
        <div class="table-responsive">

        <table class="fade-in">
            <thead>
                <tr>
                    <th>
                        <a href="javascript:void(0);" class="sortable" data-column="id">ID
                            <span class="sort-arrow"></span>
                        </a>
                    </th>
                    <th>
                        <a href="javascript:void(0);" class="sortable" data-column="name">Nombre
                            <span class="sort-arrow"></span>
                        </a>
                    </th>
                    <th>Imagen</th>
                    <th>
                        <a href="javascript:void(0);" class="sortable" data-column="type">Tipo
                            <span class="sort-arrow"></span>
                        </a>
                    </th>
                    <th>Ingredientes</th>
                    <th>Instrucciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="recipe-list"></tbody>
        </table>

        </div>

        <!-- Paginación -->
        <div class="pagination" id="pagination"></div>

        <!-- Botones para añadir receta y salir -->
        <a href="add_recipe.php" class="add-btn">Añadir Receta</a>
        <a href="logout.php" class="logout-btn">Salir</a>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal" id="delete-modal">
        <div class="modal-message">Receta eliminada</div>
        <button class="close-btn" id="close-modal">Cerrar</button>
    </div>

    <script>
    $(document).ready(function() {
        var currentPage = 1;
        var orderColumn = 'id';
        var orderDirection = 'ASC';
        var searchQuery = '';

        // Mostrar modal si la URL tiene el parámetro 'deleted=true'
        if (window.location.search.indexOf('deleted=true') !== -1) {
            $('#delete-modal').addClass('show'); // Muestra el modal de confirmación de eliminación
        }

        // Cerrar el modal cuando el usuario haga clic en el botón de cerrar
        $('#close-modal').on('click', function() {
            $('#delete-modal').removeClass('show');
            window.history.replaceState({}, document.title, window.location.pathname); // Elimina el parámetro de la URL
        });

        // Función para cargar recetas
        function loadRecipes() {
            $.ajax({
                url: 'recipes_ajax.php', // Archivo que manejará la carga de recetas
                method: 'GET',
                data: {
                    page: currentPage, // Número de página
                    order_column: orderColumn, // Columna por la que se ordenarán los resultados
                    order_direction: orderDirection, // Dirección de ordenación (ASC o DESC)
                    search: searchQuery // Consulta de búsqueda
                },
                success: function(response) {
                    var data = JSON.parse(response); // Convierte la respuesta JSON a un objeto
                    renderRecipes(data.recipes); // Renderiza las recetas
                    renderPagination(data.total_pages, data.current_page); // Renderiza la paginación
                    updateEntryCounter(data.total_entries); // Actualiza el contador de recetas
                }
            });
        }

        // Renderizar las recetas con animación
        function renderRecipes(recipes) {
            var html = '';
            recipes.forEach(function(recipe) {
                html += '<tr>';
                html += '<td>' + recipe.id + '</td>';
                html += '<td>' + recipe.name + '</td>';
                html += '<td><img src="' + recipe.image_url + '" alt="Comida" width="50"></td>';
                html += '<td>' + recipe.type + '</td>';
                html += '<td>' + recipe.ingredients + '</td>';
                html += '<td>' + recipe.instructions + '</td>';
                html += '<td><div class="button-container"><a href="edit_recipe.php?id=' + recipe.id + '" class="edit-btn">Editar</a> <a href="delete_recipe.php?id=' + recipe.id + '" class="delete-btn">Eliminar</a></div></td>';
                html += '</tr>';
            });

            // Aplicar la clase fade-in para animar la tabla
            $('#recipe-list').html(html).addClass('fade-in');

            // Eliminar la clase fade-in después de la animación para permitir que se repita en futuras actualizaciones
            setTimeout(function() {
                $('#recipe-list').removeClass('fade-in');
            }, 500); // El tiempo coincide con la duración de la animación (0.5s)
        }

        // Renderizar la paginación
        function renderPagination(totalPages, currentPage) {
            var html = '';
            for (var i = 1; i <= totalPages; i++) {
                html += '<a href="javascript:void(0);" class="pagination-link ' + (i === currentPage ? 'active' : '') + '" data-page="' + i + '">' + i + '</a>';
            }
            $('#pagination').html(html);
        }

        // Actualizar el contador de entradas
        function updateEntryCounter(totalEntries) {
            $('#entry-counter').text(totalEntries + ' Entradas');
        }

        // Manejar el evento de clic en la paginación
        $(document).on('click', '.pagination-link', function() {
            currentPage = $(this).data('page'); // Actualiza la página actual
            loadRecipes(); // Vuelve a cargar las recetas
        });

        // Manejar la búsqueda
        $('#search').on('input', function() {
            searchQuery = $(this).val(); // Actualiza la consulta de búsqueda
            loadRecipes(); // Vuelve a cargar las recetas con la nueva búsqueda
        });

        // Manejar el clic en las cabeceras para ordenar
        $(document).on('click', '.sortable', function() {
            orderColumn = $(this).data('column'); // Obtiene la columna por la que se ordenará
            orderDirection = orderDirection === 'ASC' ? 'DESC' : 'ASC'; // Alterna entre ASC y DESC
            loadRecipes(); // Vuelve a cargar las recetas con el nuevo orden
        });

        // Cargar las recetas inicialmente
        loadRecipes();
    });

    $(document).ready(function() {
    // Mostrar el modal de éxito si el parámetro 'added=true' o 'modified=true' está presente
    if (window.location.search.indexOf('added=true') !== -1) {
        $('#success-modal-added').addClass('show');
    }

    if (window.location.search.indexOf('modified=true') !== -1) {
        $('#success-modal-modified').addClass('show');
    }

    // Cerrar el modal de éxito cuando el usuario hace clic en el botón "Cerrar"
    $('#close-success-modal-added').on('click', function() {
        $('#success-modal-added').removeClass('show');
        window.history.replaceState({}, document.title, window.location.pathname); // Elimina el parámetro 'added=true' de la URL
    });

    $('#close-success-modal-modified').on('click', function() {
        $('#success-modal-modified').removeClass('show');
        window.history.replaceState({}, document.title, window.location.pathname); // Elimina el parámetro 'modified=true' de la URL
    });
});

    </script>
</body>
</html>




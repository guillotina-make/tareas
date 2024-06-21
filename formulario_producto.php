<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario CRUD de Productos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
       /* Estilos generales */
       body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }

        h2 {
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        /* Estilos para formularios */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Estilos para tablas */
        #tablaProductos {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Estilos adicionales */
        hr {
            margin-top: 40px;
            margin-bottom: 40px;
            border: 0;
            border-top: 1px solid #ccc;
        }

        /* Estilos para botones */
.eliminar-btn, .editar-btn {
    background-color: #007bff; /* Azul */
    color: white;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    border-radius: 4px;
    text-decoration: none;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.eliminar-btn:hover, .editar-btn:hover {
    background-color: #0056b3; /* Azul oscuro */
}

/* Estilos adicionales */
.btn-red {
    background-color: #f44336; /* Rojo */
}

.btn-red:hover {
    background-color: #cc0000; /* Rojo oscuro */
}

.btn-blue {
    background-color: #007bff; /* Azul */
}

.btn-blue:hover {
    background-color: #0056b3; /* Azul oscuro */
}

    </style>

    <script>
    $(document).ready(function(){
        // Función para cargar la tabla de productos al cargar la página
        cargarTabla();

        // Captura el evento submit del formulario
        $('#formulario').submit(function(event){
            // Evita el comportamiento predeterminado de enviar el formulario
            event.preventDefault();

            // Recolecta los datos del formulario
            var formData = $(this).serialize();

            // Envía la solicitud AJAX
            $.ajax({
                type: 'POST',
                url: 'guardar_producto.php', // Ruta al script PHP que procesa el formulario
                data: formData,
                success: function(response){
                    // Actualiza la tabla de productos después de guardar o actualizar
                    $('#tablaProductos').html(response);
                    // Limpia el formulario después de guardar o actualizar
                    limpiarFormulario();
                    alert('Operación realizada correctamente');
                },
                error: function(xhr, status, error){
                    console.error('Error al procesar la operación: ' + error);
                }
            });
        });

        // Función para eliminar un producto
        $(document).on('click', '.eliminar-btn', function(){
            if (confirm('¿Estás seguro de eliminar este producto?')) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'eliminar_producto.php',
                    data: { id: id },
                    success: function(response){
                        $('#tablaProductos').html(response);
                        alert('Producto eliminado correctamente');
                    },
                    error: function(xhr, status, error){
                        console.error('Error al eliminar el producto: ' + error);
                    }
                });
            }
        });

        // Función para cargar los datos en el formulario de actualización
        $(document).on('click', '.editar-btn', function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'cargar_datos_producto.php',
                data: { id: id },
                dataType: 'json',
                success: function(data){
                    $('#nombre').val(data.nombre);
                    $('#precio').val(data.precio);
                    $('#stock').val(data.stock);
                    // Establecer el ID del producto a actualizar
                    $('#id_actualizar').val(id);
                    $('#formulario').append('<input type="hidden" name="id_actualizar" value="' + id + '">');
                    $('#formulario').append('<input type="submit" value="Actualizar">');
                },
                error: function(xhr, status, error){
                    console.error('Error al cargar datos para actualizar: ' + error);
                }
            });
        });
    });

    // Función para limpiar el formulario de actualización
    function limpiarFormulario() {
        $('#id_actualizar').val('');
        $('#formulario input[type="submit"]').remove();
        $('#formulario input[type="hidden"]').remove();
    }

    // Función para cargar la tabla de productos
    function cargarTabla() {
        $.ajax({
            type: 'GET',
            url: 'mostrar_productos.php',
            success: function(response){
                $('#tablaProductos').html(response);
            },
            error: function(xhr, status, error){
                console.error('Error al cargar la tabla de productos: ' + error);
            }
        });
    }
    </script>
</head>
<body>
    <h2>Formulario de Gestión de Productos</h2>
    <form id="formulario">
        <input type="hidden" id="id_actualizar" name="id_actualizar">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" min="0" step="0.01" required><br><br>
        
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" min="0" required><br><br>
        
        <input type="submit" value="Guardar">
    </form>
    
    <hr>
    
    <h2>Productos Registrados</h2>
    <div id="tablaProductos">
        <?php include 'mostrar_productos.php'; ?>
    </div>
</body>
</html>

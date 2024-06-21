<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario CRUD</title>
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
        input[type="number"],
        input[type="email"] {
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

        /* Estilos para botones */
        .eliminar-btn {
            background-color: #f44336; /* Rojo */
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 5px;
        }

        .eliminar-btn:hover {
            background-color: #cc0000; /* Rojo oscuro */
        }

        .editar-btn {
            background-color: #007bff; /* Azul */
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 5px;
        }

        .editar-btn:hover {
            background-color: #0056b3; /* Azul oscuro */
        }

        /* Estilos para tablas */
        #tablaDatos {
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
    </style>

    <script>
    $(document).ready(function(){
        // Función para cargar la tabla de registros al cargar la página
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
                url: 'guardar.php', // Ruta al script PHP que procesa el formulario
                data: formData,
                success: function(response){
                    // Actualiza la tabla de datos después de guardar o actualizar
                    $('#tablaDatos').html(response);
                    // Limpia el formulario después de guardar o actualizar
                    limpiarFormulario();
                    alert('Operación realizada correctamente');
                },
                error: function(xhr, status, error){
                    console.error('Error al procesar la operación: ' + error);
                }
            });
        });

        // Función para eliminar un registro
        $(document).on('click', '.eliminar-btn', function(){
            if (confirm('¿Estás seguro de eliminar este registro?')) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'eliminar.php',
                    data: { id: id },
                    success: function(response){
                        $('#tablaDatos').html(response);
                        alert('Registro eliminado correctamente');
                    },
                    error: function(xhr, status, error){
                        console.error('Error al eliminar el registro: ' + error);
                    }
                });
            }
        });

        // Función para cargar los datos en el formulario de actualización
        $(document).on('click', '.editar-btn', function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'cargar_datos.php',
                data: { id: id },
                dataType: 'json',
                success: function(data){
                    $('#nombre').val(data.nombre);
                    $('#edad').val(data.edad);
                    $('#email').val(data.email);
                    // Establecer el ID del registro a actualizar
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

    // Función para cargar la tabla de registros
    function cargarTabla() {
        $.ajax({
            type: 'GET',
            url: 'mostrar_registros.php',
            success: function(response){
                $('#tablaDatos').html(response);
            },
            error: function(xhr, status, error){
                console.error('Error al cargar la tabla de registros: ' + error);
            }
        });
    }
    </script>
</head>
<body>
    <h2>Formulario de Datos</h2>
    <form id="formulario">
        <input type="hidden" id="id_actualizar" name="id_actualizar">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <input type="submit" value="Guardar">
    </form>
    
    <hr>
    
    <h2>Registros Guardados</h2>
    <div id="tablaDatos">
        <?php
        // Conexión a la base de datos (misma configuración que antes)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "crud_ejemplo";

        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta SQL para obtener todos los registros
        $sql = "SELECT id, nombre, edad, email FROM usuarios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Edad</th><th>Email</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["nombre"]."</td>";
                echo "<td>".$row["edad"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron registros";
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>
</body>
</html>

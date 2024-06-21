<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_ejemplo";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_actualizar']) && !empty($_POST['id_actualizar'])) {
        // Actualizar producto
        $id_actualizar = $_POST['id_actualizar'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];

        $sql_update = "UPDATE productos SET nombre='$nombre', precio=$precio, stock=$stock WHERE id=$id_actualizar";

        if ($conn->query($sql_update) === TRUE) {
            include 'mostrar_productos.php';
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    } else {
        // Insertar nuevo producto
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];

        $sql_insert = "INSERT INTO productos (nombre, precio, stock) VALUES ('$nombre', $precio, $stock)";

        if ($conn->query($sql_insert) === TRUE) {
            include 'mostrar_productos.php';
        } else {
            echo "Error al guardar los datos: " . $conn->error;
        }
    }
}


?>

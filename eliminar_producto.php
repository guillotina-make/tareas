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
    $id_eliminar = $_POST['id'];

    $sql_delete = "DELETE FROM productos WHERE id=$id_eliminar";

    if ($conn->query($sql_delete) === TRUE) {
        include 'mostrar_productos.php';
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}


?>

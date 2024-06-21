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
    $id_cargar = $_POST['id'];

    $sql_select = "SELECT nombre, edad, email FROM usuarios WHERE id=$id_cargar";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Devolver los datos en formato JSON
        echo json_encode($row);
    } else {
        echo "Error: No se encontraron datos para el ID especificado";
    }
}

// Cerrar conexión
$conn->close();
?>

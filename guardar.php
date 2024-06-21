<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud_ejemplo"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_actualizar']) && !empty($_POST['id_actualizar'])) {
        // Actualizar registro
        $id_actualizar = $_POST['id_actualizar'];
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $email = $_POST['email'];

        $sql_update = "UPDATE usuarios SET nombre='$nombre', edad=$edad, email='$email' WHERE id=$id_actualizar";

        if ($conn->query($sql_update) === TRUE) {
            include 'mostrar_registros.php';
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    } else {
        // Insertar nuevo registro
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $email = $_POST['email'];

        $sql_insert = "INSERT INTO usuarios (nombre, edad, email) VALUES ('$nombre', $edad, '$email')";

        if ($conn->query($sql_insert) === TRUE) {
            include 'mostrar_registros.php';
        } else {
            echo "Error al guardar los datos: " . $conn->error;
        }
    }
}


?>

<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "crud_ejemplo"; /

$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT user_id, password FROM usuarios_login WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if ($password === $row['password']) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['username'] = $username;

            // Redireccionar según la opción seleccionada
            if (isset($_POST['action']) && $_POST['action'] === 'usuarios') {
                header("Location: formulario_usuario.php");
                exit();
            } elseif (isset($_POST['action']) && $_POST['action'] === 'productos') {
                header("Location: formulario_producto.php"); // Cambiar a la página de productos
                exit();
            } else {
                // Por defecto, redirigir a una página principal o de bienvenida
                header("Location: index.php");
                exit();
            }
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado";
    }
}

// Cerrar conexión
$conn->close();
?>

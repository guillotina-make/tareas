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

// Consulta SQL para obtener todos los registros
$sql = "SELECT id, nombre, edad, email FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Edad</th><th>Email</th><th>Acciones</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["nombre"]."</td>";
        echo "<td>".$row["edad"]."</td>";
        echo "<td>".$row["email"]."</td>";
        echo "<td>";
        echo "<button class='eliminar-btn btn-red' data-id='".$row["id"]."'>Eliminar</button>";
        echo "<button class='editar-btn btn-blue' data-id='".$row["id"]."'>Editar</button>";        
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros";
}

// Cerrar conexión
$conn->close();
?>

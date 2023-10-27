<?php
$servername = "localhost"; // Puede ser "localhost" si estás trabajando en el mismo servidor
$username = "root";
$password = "root";
$database = "pruebas_f1";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database) or die("Error de conexion");

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}
?>

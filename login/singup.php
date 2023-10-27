<?php

include("../conexion.php"); // Incluye el archivo de conexión a la base de datos

// Obtén los datos del formulario
$email = $_POST['email'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$pass = $_POST['pass'];
$conPass = $_POST['conPass'];

// Verifica que la contraseña coincida con la confirmación de contraseña
if ($pass === $conPass) {
    // La contraseña coincide, inserta los datos en la base de datos
    
    // hash metodo para la contraseña antes de guardarla
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT); // Recomiendo usar password_hash para el almacenamiento seguro de contraseñas

    // Insertar los datos en la tabla de usuarios
    // $sql = "INSERT INTO usuarios (email, nombre, apellidos, pass) VALUES ('$email', '$nombre', '$apellidos', '$hashedPass')";
    $sql = "INSERT INTO usuarios (email, nombre, apellidos, pass, rol) VALUES ('$email', '$nombre', '$apellidos', '$hashedPass', 1)";

    if ($conn->query($sql) === TRUE) {
        // echo "Registro exitoso.";
        header("Location: login.html");
    } else {
        echo "Error al registrar usuario: " . $conn->error;
    }
} else {
    echo "Las contraseñas no coinciden.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
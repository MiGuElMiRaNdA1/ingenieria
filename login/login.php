<?php 

//include("../conexion.php"); // Incluye el archivo de conexión a la base de datos
 
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     $email = $_POST['email'];
//     $contrasena = $_POST['pass'];

//     $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE email = :email AND pass = :pass");
//     $consulta->bindParam(':email', $email);
//     $consulta->bindParam(':pass', $pass);
//     $consulta->execute();

//     $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

//     if ($usuario['rol_id'] == 1) {
//         $_SESSION['usuario'] = $usuario;
//         header('Location: index.html');
//         exit;
//     } else if ($usuario['rol_id'] == 2) {
//         $_SESSION['usuario'] = $usuario;
//         header('Location: administrar_usuarios.php');
//         exit;
//     } else {
//         echo "Los Datos ingresados son incorrectos.";
//     }

//     // Cerrar la conexión después de la consulta
//     $conexion = null;
//     }

// Realiza una consulta para verificar los datos
// $sql = "SELECT * FROM usuarios WHERE email = '$email' AND pass = '$pass'";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // Los datos son correctos, el usuario ha iniciado sesión con éxito.
//     echo "Inicio de sesión exitoso.";
// } else {
//     // Los datos son incorrectos, muestra un mensaje de error o redirige al usuario.
//     echo "Inicio de sesión fallido. Comprueba tus credenciales.";
// }

// // Cierra la conexión a la base de datos
// $conn->close();

// ?>

<?php
include "../conexion.php"; // Incluye el archivo de conexión a la base de datos

// Obtén los datos del formulario
$email = $_POST['email'];
$pass = $_POST['pass'];

// Busca el registro del usuario en la base de datos por su email
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // El email existe en la base de datos, obtén el registro
    $row = $result->fetch_assoc();
    
    // Verifica la contraseña utilizando password_verify
    if (password_verify($pass, $row['pass'])) {
        echo "Contraseña válida, el usuario ha iniciado sesión con éxito";
        //echo "Inicio de sesión exitoso.";
        //header('Location: ../index/index.html');
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta. Inténtalo de nuevo.";
    }
} else {
    // El email no existe en la base de datos
    echo "Email no registrado. Regístrate primero.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
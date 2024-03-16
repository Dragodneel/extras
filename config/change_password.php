
<?php 
require_once('database.php');

$id = $_POST['id'];
$pass = $_POST['new_password'];

// Verificar si la contraseña está vacía
if(empty($pass)) {
    header("Location: ../index.php?message=empty_password");
    exit; // Detener la ejecución del script
}

// Preparar la consulta SQL con una declaración preparada para evitar inyección SQL
$query = "UPDATE usuarios SET contrasena = ? WHERE doc = ?";
$stmt = $conexion->prepare($query);

// Vincular parámetros
$stmt->bind_param("si", $pass, $id);

// Ejecutar la consulta
if ($stmt->execute()) {
    header("Location: ../index.php?message=success_password");
} else {
    header("Location: ../index.php?message=error_password");
}

$stmt->close();
$conexion->close();
?>

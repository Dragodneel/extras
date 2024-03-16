<?php
require_once('database.php');

$id = $_POST['id'];
$pin = $_POST['pin'];


// Verificar si el pin está vacío
if (empty($id)) {
    header("Location: ../index.php?message=empty_id");
    exit; // Detener la ejecución del script
} else {
    // Verificar el PIN en la base de datos
    $query = "SELECT * FROM usuarios WHERE doc = ? AND pin = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("is", $id, $pin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // PIN correcto, redirigir a la página de cambio de contraseña
        header("Location: ../change_password.php?id=$id&message=correct_pin");
        exit;
    } else {
        // PIN incorrecto, redirigir a la página de inicio con un mensaje de error
        header("Location: ../index.php?message=incorrect_pin");
        exit;
    }
}

$stmt->close();
$conexion->close();
?>

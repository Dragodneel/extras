<?php
	require 'includes/database.php';
    $db = new Database();
    $conexion = $db->conectar();


// Función para generar un PIN aleatorio
function generarPIN($longitud = 6) {
    $caracteres = '0123456789';
    $pin = '';
    for ($i = 0; $i < $longitud; $i++) {
        $pin .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $pin;
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo electrónico proporcionado por el usuario
    $correo = $_POST['correo'];

    // Generar un PIN aleatorio
    $pin = generarPIN();

    try {
        // Preparar la consulta para actualizar el registro en la base de datos con el nuevo PIN
        $stmt = $conexion->prepare("UPDATE usuarios SET pin = :pin WHERE email = :correo");
        $stmt->bindParam(':pin', $pin);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        // Configurar el servidor SMTP y el puerto
        ini_set('SMTP', 'tudirecciondesmtp.com');
        ini_set('smtp_port', 465); // Puerto SMTP seguro típico es 587 o 465

        // Envía el PIN por correo electrónico
        $mensaje = "Tu código PIN para restablecer la contraseña es: $pin";
        $asunto = "Restablecimiento de contraseña";
        $cabeceras = "From: tuemail@example.com";

        if (mail($correo, $asunto, $mensaje, $cabeceras)) {
            echo "Se ha enviado un correo electrónico con un PIN para restablecer la contraseña.";
        } else {
            echo "Error al enviar el correo electrónico. Por favor, inténtalo de nuevo más tarde.";
        }
    } catch (PDOException $e) {
        echo "Error al generar el código PIN. Por favor, inténtalo de nuevo más tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <h2>Restablecer Contraseña</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="correo">Correo electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>
        <input type="submit" value="Enviar PIN">
    </form>
</body>
</html>

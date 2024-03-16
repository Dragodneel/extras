<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require 'database.php';

// Función para generar un PIN aleatorio
function generarPIN($longitud = 4) {
    $caracteres = '0123456789';
    $pin = '';
    for ($i = 0; $i < $longitud; $i++) {
        $pin .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $pin;
}

$email = $_POST['email'];
$query = "SELECT * FROM usuarios WHERE email = ? AND estado = 'A'";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $pin = generarPIN();

    // Actualizar el PIN en la base de datos
    try {
        $update_stmt = $conexion->prepare("UPDATE usuarios SET pin = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $pin, $email);
        $update_stmt->execute();
    } catch (PDOException $e) {
        echo "Error al generar el código PIN. Por favor, inténtalo de nuevo más tarde.";
        exit;
    }

    // Envío del correo electrónico
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'imjpaul2001@gmail.com';
        $mail->Password   = 'jozc ofqf qcbk oajg';
        $mail->Port       = 587;

        $mail->setFrom('imjpaul2001@gmail.com', 'sembradoras');
        $mail->addAddress($row['email'], 'usuario');
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body    = "Hola, este es un correo generado para solicitar tu recuperación de contraseña. Tu código PIN para restablecer la contraseña es: $pin <br>";
        $mail->Body   .= "Recuerde que tiene 2 horas hasta el cese del PIN para restablecer su contraseña";
        $mail->Body   .= "Por favor, visita la página de <a href='localhost/LOGIN/validar_pin.php?id=".$row['doc']."'>Validación de PIN</a>";
        
        if ($mail->send()) {
            header("Location: ../index.php?message=ok");
            exit;
        } else {
            header("Location: ../index.php?message=error");
            exit;
        }
    } catch (Exception $e) {
        header("Location: ../index.php?message=error");
        exit;
    }
} else {
    header("Location: ../index.php?message=not_found");
    exit;
}
?>

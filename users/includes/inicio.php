<?php 
require 'database.php';

$db = new Database();
$con = $db->conectar();

if($_POST["inicio"])
{
    
    $usuario = $_POST["usuario"];
	$clave = $_POST["clave"];
    if ($usuario == "" || $clave == "")
    {
        echo"<script>alert('Datos Vacios')</script>";
	    echo"<script>window.location='../../index.php'</script>";
    }
    else
    {
        $sql = $con->prepare("SELECT * 
        FROM usuarios LEFT OUTER JOIN ti_us 
        ON usuarios.id_ti_us = ti_us.id_ti_us
         WHERE usuarios.doc = $usuario AND usuarios.contrasena = '$clave' 
         AND usuarios.estado = 'A' ");
        $sql->execute();
        $fila = $sql->fetch();  # Fetch para un solo registro fetchall para mas de un registro
        
        if (password_verify($clave, $fila['contrasena'])) {
            $_SESSION['usuario'] = $fila['doc'];
            $_SESSION['tipo'] = $fila['id_ti_us'];
            $_SESSION['estado'] = $fila['estado'];

            if ($_SESSION['tipo'] == 2) {
                header("Location: ../user/index.html");
                exit();
            }
            if ($_SESSION['tipo'] == 1) {
                header("Location: ../admin/index.html");
                exit();
            }
        }
        else
        {
            echo"<script>alert('Credenciales invalidas o usuario inactivo.')</script>";
            echo"<script>window.location='../../index.php'</script>";
            exit();
        }
}
}	
?>
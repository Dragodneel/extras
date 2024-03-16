<?php
	require 'includes/database.php';
    $db = new Database();
    $con = $db->conectar();


if (isset($_POST['save'])) 
{
    if (empty($_POST['document']) || empty($_POST['names']) || empty($_POST['id_ti_us']) 
    || empty($_POST['email']) || empty($_POST['contra'])) 
    {

		echo"<script>alert('Existen Datos vacios.')</script>";
		echo"<script>window.location='registrar_usuario.php'</script>";
	} 
        $doc       = $_POST['document'];
        $nombre          = $_POST['names'];
        $email          = $_POST['email'];
        $contrasena         = $_POST['contra'];
        $id_ti_us      = $_POST['id_ti_us'];
        $estado       = "A";

        echo $doc;
        echo "   ";
        echo $nombre;
        echo "   ";
        echo $email;
        echo "   ";
        echo $contrasena;
        echo "   ";
        echo $id_ti_us;
        echo "   ";
        echo $estado;



        /*$activo = 'Activo';
        $suscrip = 'Inactivo';*/
    
        $sql = $con->prepare("SELECT * FROM usuarios WHERE doc = $doc");
        $sql->execute();
        $resul = $sql->fetch();
          
        if ($resul['doc'] == $doc) 
        {
             echo "<script>alert('DOCUMENTO YA ESTA EN LA BASE DE DATOS.')</script>";
             echo "<script>window.location='registrar_usuario.php'</script>";
        }
        else
        {
            /*$id_user = 2;
            $rutaEnServidor='../img/proyectos/user';
            $rutaTemporal=$_FILES['imagen']['tmp_name'];
            $nombreImagen=$_FILES['imagen']['name'];
            $rutaDestino=$rutaEnServidor.'/'.$nombreImagen;
            move_uploaded_file($rutaTemporal,$rutaDestino);*/

            
            $pass = password_hash($contrasena, PASSWORD_DEFAULT, array("contra"=>12));

            $insert = $con->prepare( "INSERT INTO usuarios(doc, nombre, email, contrasena, id_ti_us, estado)
             values (?,?,?,?,?,?)");
            $insert->execute([$doc,  $nombre, $email, $pass, $id_ti_us, $estado]);       
            $id = $con->lastInsertId();
            echo"<script>alert('Se agrego correctamente')</script>";
            echo"<script>window.location='../index.html'</script>";
        }
    
	}
?>
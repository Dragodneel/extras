<?php
	require 'includes/database.php';
    $db = new Database();
    $con = $db->conectar();



    if(isset($_GET['eliminar']) && !empty($_GET['eliminar'])) {
        $eliminar_id = $_GET['eliminar'];
        $eliminar = $con->prepare("DELETE FROM usuarios WHERE doc = ?");
        $eliminar->execute([$eliminar_id]);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }


    // Procesar edición
    if(isset($_POST['editar'])) {
        if (empty($_POST['document']) || empty($_POST['names']) || empty($_POST['id_ti_us']) 
    || empty($_POST['email']) || empty($_POST['contra'])) 
    {

		echo"<script>alert('Existen Datos vacios.')</script>";
		echo"<script>window.location='registrar_usuario.php'</script>";
	}
        $editar_id = $_POST['doc'];
        $editar_nom = $_POST['nombre'];
        $editar_email = $_POST['email'];
        $editar_estado = $_POST['estado'];
        $editar_ti_us = $_POST['id_ti_us'];
        $editar = $con->prepare("UPDATE usuarios SET nombre = ?, email = ?, estado = ?, id_ti_us = ? WHERE doc = ?");
        $editar->execute([$editar_nom, $editar_email, $editar_estado, $editar_ti_us, $editar_id]);
        header("Location: ".$_SERVER['PHP_SELF']);
        echo"<script>alert('Existen Datos.')</script>";
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <h2>Lista de usuarios de la tabla.</h2>

    <?php
        $insert = $con->prepare ('select * from usuarios INNER JOIN ti_us on usuarios.id_ti_us = ti_us.id_ti_us');
        $insert->execute();
        $resul = $insert->fetchAll(PDO::FETCH_ASSOC);
        $i=0;
    ?>
    <table border="2">
        <tr>
            <td>#</td>
            <td>Doc</td>
            <td>Nombres</td>
            <td>Email</td>
            <td>Tipo Usuario</td>
            <td>Estado</td>
            <td>eliminar</td>
            <td>actualizar</td>
        </tr>
        <?php foreach ($resul as $row) {   
             $i++;  ?>
            
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row ["doc"]; ?></td>
                <td><?php echo $row ["nombre"]; ?></td>
                <td><?php echo $row ["email"]; ?></td>
                <td><?php echo $row ["ti_us"]; ?></td>
                <td><?php echo $row ["estado"]; ?></td>
                <td>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal_eliminar_<?php echo $row["doc"]; ?>">Eliminar</button>
                </td>
                <td>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_editar_<?php echo $row["doc"]; ?>">Editar</button>
                </td>
            </tr>
            <!-- Modal para eliminar -->
            <div class="modal fade" id="modal_eliminar_<?php echo $row["doc"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Eliminar Rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas eliminar este rol?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              <a href="?eliminar=<?php echo $row["doc"]; ?>" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para editar -->
            <div class="modal fade" id="modal_editar_<?php echo $row["doc"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Rol</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="doc" value="<?php echo $row["doc"]; ?>">
                                <div class="mb-3">
                                    <input type="text" onkeyup="mayus(this);"  pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().!#$%&’*+/=?^_`{|}~-].,\s ]{2,520}" class="form-control" name="nombre" value="<?php echo $row["nombre"]; ?>" placeholder="Nombre" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" onkeyup="mayus(this);"  pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().!#$%&’*+/=?^_`{|}~-].,\s ]{2,520}" class="form-control" name="email" value="<?php echo $row["email"]; ?>" placeholder="Correo">
                                </div>
                                <div class="mb-3">
                                    <input type="text" onkeyup="mayus(this);"  pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().!#$%&’*+/=?^_`{|}~-].,\s ]{2,520}" class="form-control" name="estado" value="<?php echo $row["estado"]; ?>" placeholder="estado" maxleight="1">
                                </div>
                                <div class="mb-3">
                                    <select class="form-control" name="id_ti_us" id="id_ti_us" required>
                                        <option value="" select=""><?php echo $row["ti_us"]; ?></option>
                                            <?php
                                            $statement = $con->prepare('SELECT * FROM ti_us');
                                            $statement->execute();
                                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value=" . $row['id_ti_us'] . ">" . $row['ti_us'] . "</option>";
                                            }
                                            ?>
                                     </select> 
                                </div>
                                    <button type="submit" class="btn btn-primary" name="editar">Editar</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </table>
</body>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js"></script>

</html>
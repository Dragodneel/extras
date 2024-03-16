<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" name="form1" id="form1" action="users/includes/inicio.php" autocomplete="off" style="margin-left: auto;">
        <div>
            <label for="cargo"> &nbsp;<strong>DOCUMENTO </strong></label>
            <input type="text" id="usuario" name="usuario" maxlength="10" >
        </div>
        
        <div>
            <label for="cargo"> &nbsp;<strong>CONTRASEÑA </strong></label>
            <input type="password" id="clave" name="clave" maxlength="20" >   
        </div>
        
        <div>
            <input type="submit" name="inicio" id="inicio" value="   Entrar   " />
        </div><br>
        
        <div>
            <a href="recovery.php"><h6>Olvide mi contraseña</h6></a>
        </div>




        <div>
            <a href="users/registrar_usuario.php"><h6>Registrarse</h6></a>
        </div>
        <div>
            <a href="users/ver_user.php"><h6>Ver usuario</h6></a>
        </div><br>



        <div>
            <a href="users/puntos.php"><h6>Ver Puntos</h6></a>
        </div>
        <div>
            <a href="users/ver_roles.php"><h6>Ver rol2</h6></a>
        </div>
        <input type="hidden" name="MM_insert" value="form1">
    </form>
    <?php 
    if(isset($_GET['message'])){
     
    ?>
      <div class="alert alert-primary" role="alert">
        <?php 
        switch ($_GET['message']) {
          case 'ok':
            echo 'Por favor, revisa tu correo';
            break;
          case 'success_password':
            echo 'Inicia sesión con tu nueva contraseña';
            break;
            
          default:
            echo 'Algo salió mal, intenta de nuevo';
            break;
        }
        ?>
      </div>
    <?php
    }
    ?>
  </form>
  
</main>

<script>
  function deshabilitaRetroceso(){
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; // Para Chrome
    window.onhashchange = function() { window.location.hash = "no-back-button"; };
    
    // Deshabilitar la funcionalidad del botón de retroceso del navegador
    history.pushState(null, document.title, location.href);
    window.addEventListener('popstate', function (event) {
        history.pushState(null, document.title, location.href);
    });
}
</script>
    
  </body>
</html>
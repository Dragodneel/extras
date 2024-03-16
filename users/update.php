<?php

require 'includes/database.php';
/*require '../config/database.php';
require '../config/config.php';
require '../config/scripts.php';*/

$db = new Database();
$con = $db->conectar();
if (isset($_POST['cambio']))
{
    $email = ($_POST['email']);
    $doc = ($_POST['doc']);
     $sql1 = $con->prepare("SELECT count(email) FROM usuarios WHERE email = '$email' AND doc = $doc LIMIT 1");
     $sql1->execute();
     if($sql1->fetchColumn() > 0)
     {
          $sqlemail = $con->prepare("SELECT * FROM usuarios WHERE email = '$email' AND doc = $doc LIMIT 1");
          $sqlemail->execute();
          $row = $sqlemail->fetch(PDO::FETCH_ASSOC);
        //  echo $row['email'];
        //  echo $row['document'];
        
    }
    else{
        echo"<script>alert('Email y/o Documento Invalido, verifique!!')</script>";
        echo"<script>window.location='recuperar_cont.php'</script>";
    
    }
}

    if (isset($_POST['cambiar'])){
   $contra = $_POST['contra'];
   $docu = $_POST['doc'];
   
      
   $insert = $con->prepare( "UPDATE usuarios SET contrasena=? WHERE doc = $docu");
   $insert->execute([$contra]);       
   
   echo"<script>alert('Se actualizo la contraseña')</script>";
   echo"<script>window.location='login.php'</script>";

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Recuperar Contraseña</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/LOGO.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-0 pe-5">
        <a href="../index.html" class="navbar-brand ps-5 me-0">
        <img src="../img/logo3.png">
        </a>

       
    </nav>
    <!-- Navbar End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px; ">
            <div class="row gy-5 gx-4">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    <!-- LIBRE -->
                   
                </div>
            </div>
        </div>
    </div>
    <div class="container" align="center">
        <fieldset class="mb-4">
            <legend><i class="fas fa-user" ></i> &nbsp; NUEVA CONTRASEÑA</legend>
                <form role="form" class="form-horizontal" method="post" name="form1" id="form1" action="<?php $_SERVER['PHP_SELF']?>" autocomplete="off">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="col-12 col-md-9">
                            <div class="form-outline mb-4">
                                <div class="mb-4">
                                    <div class="form-outline mb-4">
                                        <label for="contra" class="nav-link"> &nbsp;<strong>ESCRIBA SU CONTRASEÑA </strong></label>
                                            <input type="hidden" id="doc" value="<?php echo $row['doc'] ?>" class="form-control Input" name="doc">
                                            <input type="password" id="contra" pattern="[A-Za-z0-9!?-]{8,10}" class="form-control Input" name="contra" title="Minimo 8 y Máximo 10 caracteres letras y Números" required>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        
                        <input type="submit" name="cambiar" id="btn_login" value="   Cambiar   " class="btn btn-info center-block"/>
                    </div><br>
                    
                    <input type="hidden" name="MM_insert" value="form1">
                </form>
            </fieldset>
    </div>


    <!-- Back to Top -->
    


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

</body>

</html>
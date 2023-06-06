<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Cybersafe-Register</title>
    <link rel="stylesheet" href="../styles/register.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
</head>

<?php
$servername = "aws.connect.psdb.cloud";
$username = "c6bmjg9yub1tb8qqvyvh";
$password = "pscale_pw_yfxdHE3lcawXlPhH7BduqVNk07vB9ckrok6BzVRyMJL";
$dbname = "cybersafe_db";
$ssl = "C:/xampp/htdocs/html/cacert.pem"; // Ruta completa al archivo cacert.pem

$conn = mysqli_init();
$conn->ssl_set(NULL, NULL, $ssl, NULL, NULL);
$conn->real_connect($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Verificar si la conexión fue exitosa
if (mysqli_connect_errno()) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de registro
    $nombreUsuario = $_POST['nombre_usuario'];
    $apellidoUsuario = $_POST['apellido_usuario'];
    $correoUsuario = $_POST['correo_usuario'];
    $contrasena = $_POST['contrasena'];
    
    // Consultar la base de datos para verificar si el correo ya está registrado
    $sql = "SELECT * FROM usuarios WHERE correo_usuario = '$correoUsuario'";
    $resultado = mysqli_query($conn, $sql);

    // Verificar si se encontró un usuario con el correo proporcionado
    if (mysqli_num_rows($resultado) > 0) {
        // Mostrar un mensaje de error si el correo ya está registrado
        echo "<p style='display:flex; text-align: center; justify-content: center; color: red; padding-top: 10px;'>El correo ya está registrado</p>";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, correo_usuario, contrasena, id_subscripcion) 
                VALUES ('$nombreUsuario', '$apellidoUsuario', '$correoUsuario', '$contrasena', 1)";
        if (mysqli_query($conn, $sql)) {
            // El registro se realizó correctamente
            echo "<p style='display:flex; text-align: center; justify-content: center; color: green; padding-top: 10px;'>Registro exitoso</p>";
        } else {
            // Mostrar un mensaje de error si no se pudo realizar el registro
            echo "<p style='display:flex; text-align: center; justify-content: center; color: red; padding-top: 10px;'>Error en el registro: " . mysqli_error($conn) . "</p>";
        }
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
<body>
    <section id="nav-bar">    
      <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="../html/index.html">
          <img src="../images/main-logo.png" alt="texto alternativo de la imagen">
          Cybersafe
      </a>
      
      <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Contenidos
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Documentación Legal</a>
                <a class="dropdown-item" href="#">Normatividad</a>
                <a class="dropdown-item" href="../html/courses.html">Cursos</a>
                <a class="dropdown-item" href="#">Instituciones</a>
                <a class="dropdown-item" href="../html/enlacesInteres.html">Enlaces de interes</a>
                <a class="dropdown-item" href="#">Herramientas</a>
                <a class="dropdown-item" href="#">Empresarial</a>
                <a class="dropdown-item" href="#">Desarrollo</a>
              </ul>
            </li>
            <li class="nav-item active">
                <a class="nav-link" id="ingreso">Ingreso</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" id="registro">Registro</a>
              </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Busqueda</button> 
        </form>
      </div>
    </nav>
  </section>

    <div class="container-login">
        <div class="border">
            <div class="form-login">
                <form id="form_login" class="px-4 py-3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="exampleDropdownFormUser">Nombre Usuario</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <label for="exampleDropdownFormUser2">Apellido Usuario</label>
                    <input type="text" class="form-control" id="apellido_usuario" name="apellido_usuario" placeholder="Apellido" required>
                </div>
                <div class="form-group">
                    <label for="exampleDropdownFormEmail1">Correo institucional</label>
                    <input type="email" class="form-control" id="correo_usuario" name="correo_usuario" placeholder="correo@elpoli.edu.co" required>
                </div>
                <div class="form-group">
                    <label for="exampleDropdownFormPassword1">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                </div>
                <div style="display: flex; justify-content: center;">
                  <button type="submit" class="btn-summit btn-primary">Registrarse</button>
                </div>
                <?php if (isset($error)): ?>
                  <p class="error" style="text-align: center; color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                </form>
                <div class="dropdown-divider"></div>
                <p class="dropdown-item" style="display: flex; align-items: center;">Ya tienes una cuenta? <a class="nav-link" id="ingreso2" style="font-weight: bold; cursor: pointer;">Ingresa</a></p>
                <ap class="dropdown-item" style="display: flex; align-items: center;">Olvidaste la contraseña? <a class="nav-link" id="restaurar" style="font-weight: bold; cursor: pointer;">Restaurar</a></a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
      if(window.history.replaceState){
        window.history.replaceState(null, null, window.location.href)
      }
      $(document).ready(function(){
      
      $("#ingreso").click(function(){
        window.location.href = "login.php";
        return false;
      });

      $("#ingreso2").click(function(){
        window.location.href = "login.php";
        return false;
      });

      $("#restaurar").click(function(){
        window.location.href = "restore.php";
        return false;
      });

      $("#registro").click(function(){
        window.location.href = "register.php";
        return false;
      });

      $("#form_login").submit(function(event) {
        var nombreUsuario = $("#nombre_usuario").val();
        var apellidoUsuario = $("#apellido_usuario").val();
        var contrasena = $("#contrasena").val();

        if (nombreUsuario.length < 3) {
          event.preventDefault(); // Evitar que el formulario se envíe
          alert("El nombre de usuario debe tener al menos 3 letras.");
        }

        else if (apellidoUsuario.split(" ").length < 2) {
          event.preventDefault(); // Evitar que el formulario se envíe
          alert("Deben ir sus 2 apellidos.");
        }

        else if (!isNaN(nombreUsuario) || !isNaN(apellidoUsuario)) {
          event.preventDefault(); // Evitar que el formulario se envíe
          alert("Los campos de nombre y apellido no pueden contener números.");
        }

        else if (contrasena.length < 5) {
          event.preventDefault(); // Evitar que el formulario se envíe
          alert("La contraseña debe tener al menos 5 caracteres.");
        }
      });
    });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Cybersafe-Login</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
</head>

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
        <form class="form-inline my-2 my-lg-0" style="padding-left: 65%;">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Busqueda</button> 
        </form>
      </div>
    </nav>
  </section>
  
    <div class="container-login">
        <div class="border" style="padding: 25px;">
        <h1 >CYBERSAFE - Recuperación de contraseña</h1>

<?php

function generarContraseña($longitud) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $contraseña = '';
    
    $caracteresLength = strlen($caracteres);
    for ($i = 0; $i < $longitud; $i++) {
        $indice = rand(0, $caracteresLength - 1);
        $contraseña .= $caracteres[$indice];
    }
    
    return $contraseña;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/html/PHPMailer/src/Exception.php';
require 'C:/xampp/htdocs/html/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/html/PHPMailer/src/SMTP.php';

// Configuración de la base de datos y SSL
$servername = "aws.connect.psdb.cloud";
$username = "c6bmjg9yub1tb8qqvyvh";
$password = "pscale_pw_yfxdHE3lcawXlPhH7BduqVNk07vB9ckrok6BzVRyMJL";
$dbname = "cybersafe_db";
$ssl = "C:/xampp/htdocs/html/cacert.pem"; // Ruta completa al archivo cacert.pem

// Crear una instancia de conexión a la base de datos
$conn = mysqli_init();

// Establecer la configuración SSL
$conn->ssl_set(NULL, NULL, $ssl, NULL, NULL);

// Realizar la conexión a la base de datos
$conn->real_connect($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el correo electrónico del formulario
    $email = $_POST['email'];

    // Consultar si el correo existe en la tabla "usuarios"
    $query = "SELECT * FROM usuarios WHERE correo_usuario = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // El correo existe en la tabla "usuarios"

        // Configurar los detalles del correo
        $fechaActual = date('Y-m-d H:i:s');
        $to = $email;
        $contraseñaGenerada = generarContraseña(7);
        $sql = "UPDATE usuarios SET contrasena = '$contraseñaGenerada' WHERE correo_usuario = '$email'";
        if ($conn->query($sql) === TRUE) {
            echo "La contraseña se actualizó correctamente.";
        } else {
            echo "Error al actualizar la contraseña: " . $conn->error;
            exit;
        }
        $subject = 'CyberSafe Educa - Recuperacion Contrasena';
        $message = 'Hola, solicitaste una recuperacion a las '.$fechaActual.', tu nueva contrasena es: '.$contraseñaGenerada.' CYBERSAFE EDUCA :)';

        // Crear una instancia de PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.outlook.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cybersafeeduca@hotmail.com';  // Tu dirección de correo Gmail
        $mail->Password   = 'iiwqhdnqhzwqzttt';  // Tu contraseña de correo Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('cybersafeeduca@hotmail.com');  // Tu dirección de correo y nombre
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Enviar el correo
        if ($mail->send()) {
            echo '<div class="message" style="background-color: #4CAF50; color: white; padding: 10px; border-radius: 3px; margin-bottom: 10px;">Correo enviado con éxito a: ' . $email . '</div>';
        } else {
            echo '<div class="message" style="background-color: #FF0000; color: white; padding: 10px; border-radius: 3px; margin-bottom: 10px;">Error al enviar el correo.</div>';
        }
    } else {
        // El correo no existe en la tabla "usuarios"
        echo '<div class="message" style="background-color: #FF0000; color: white; padding: 10px; border-radius: 3px; margin-bottom: 10px;">El correo ingresado no existe.</div>';
    }   
}
            $conn->close();
            ?>
            <form method="POST">
                <label for="email" style="display: block; margin-bottom: 10px;">Correo electrónico:</label>
                <input type="text" id="email" name="email" required style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; width: 200px;">

                <input type="submit" value="Enviar" style="margin-top: 10px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer;">
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
      if(window.history.replaceState){
        window.history.replaceState(null, null, window.location.href)
      }
      </script>
</body>

</html>

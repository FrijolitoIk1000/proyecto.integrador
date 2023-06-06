<?php
session_start();

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

if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

$correo = $_SESSION['correo'];

// Consulta para obtener los datos del usuario logueado
$sql = "SELECT id_usuario, nombre_usuario, apellido_usuario, id_subscripcion FROM usuarios WHERE correo_usuario = '$correo'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $id_usuario = $row["id_usuario"];
    $nombreUsuario = $row["nombre_usuario"];
    $apellidoUsuario = $row["apellido_usuario"];
    $idSubscripcion = $row["id_subscripcion"];
} else {
    $nombreUsuario = "Nombre";
    $apellidoUsuario = "Apellido";
    $idSubscripcion = 0;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Panel de control</title>
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-image: url('../images/main-logo.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center center;
    }
    
    .panel {
      width: 50%;
      max-width: 500px;
      background-color: white;
      padding: 20px;
      opacity: 0.9;
    }
    
    .panel h1 {
      margin-bottom: 20px;
    }
    
    .panel p {
      margin-bottom: 10px;
    }
    
    .panel .menu-row {
      display: flex;
      justify-content: center;
      margin-bottom: 10px;
    }
    
    .panel .menu-row button {
      margin: 0 5px;
      padding: 10px 20px;
      width: 200px;
      font-size: 18px;
      background-color: #008FC8;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .panel .menu-row button:hover {
      background-color: darkblue;
    }
    
    .panel button.logout-btn {
      margin-top: 10px;
      padding: 10px 20px;
      font-size: 18px;
      background-color: blue;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .panel button.logout-btn:hover {
      background-color: darkblue;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h1>Bienvenido, <?php echo $nombreUsuario . " " . $apellidoUsuario; ?>!</h1>
    <p>¡Has iniciado sesión correctamente en el panel de CYBERSAFE!</p>
    <div class="menu-row">
      <button onclick="window.location.href='subscripcion.php?id_usuario=<?php echo $id_usuario; ?>'">Ver mi Subscripción</button>
      <button onclick="window.location.href='progreso/progreso_academico.php?id_usuario=<?php echo $id_usuario; ?>'">Progreso Académico</button>
    </div>
    <div class="menu-row">
      <button onclick="window.location.href='certificacion.php?id_usuario=<?php echo $id_usuario; ?>'">Mis Certificaciones</button>
      <?php if ($idSubscripcion == 3): ?>
        <button onclick="window.location.href='maestria.php?id_usuario=<?php echo $id_usuario; ?>'">Mi Maestría</button>
      <?php endif; ?>
    </div>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Cerrar sesión</button>
  </div>
</body>
</html>
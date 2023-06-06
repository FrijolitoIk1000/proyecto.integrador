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

$id_usuario = $_GET['id_usuario'];

// Consulta para verificar si el id_usuario existe en la tabla progreso
$query = "SELECT * FROM progreso WHERE id_usuario = '$id_usuario'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    $progreso_curso1 = 0;
    // El id_usuario no existe en la tabla progreso, se debe agregar junto con los valores iniciales
    $query = "INSERT INTO progreso (id_usuario, progreso_curso1) VALUES ('$id_usuario', 0)";
    $conn->query($query);
}else{
    $row = $result->fetch_assoc();
    $progreso_curso1 = $row["progreso_curso1"];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Subscripción CYBERSAFE</title>
    <link rel="stylesheet" href="../../styles/login.css">
    <link rel="icon" href="../../images/favicon.ico" type="image/x-icon">
</head>

<style>
    .progress-label {
        position: absolute;
        width: 100%;
        text-align: center;
        color: #fff;
        font-weight: bold;
        font-size: 10px;
        padding-right: 30px;
    }
</style>

<body>
    <section id="nav-bar">    
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="../panel.php">
                <img src="../../images/main-logo.png" alt="texto alternativo de la imagen">
                Volver a Panel Cybersafe
            </a>
          
            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </nav>
    </section>

    <div class="container-login">
        <div class="row card-container">
            <div class="col-md-4">
                <?php if ($progreso_curso1 < 100): ?>
                <a href="curso<?php echo $progreso_curso1; ?>.php?id_usuario=<?php echo $id_usuario; ?>">
                <?php endif; ?>
                <div class="card mb-4 h-100">
                    <img class="card-img-top" src="../../images/curso1.jpg" alt="Carátula 1">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">KALI LINUX</h5>
                        <p class="card-text">Certificación en Kali Linux 2023!</p>
                        <div class="progress mt-auto">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $progreso_curso1; ?>%;" aria-valuenow="<?php echo $progreso_curso1; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <span class="progress-label" style="color: black;">Progreso <?php echo $progreso_curso1; ?>%</span>
                        </div>
                    </div>
                </div>
                <?php if ($progreso_curso1 < 100): ?>
                </a>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 h-100">
                    <img class="card-img-top" src="../../images/proximamente.jpg" alt="Carátula 1">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Curso 2</h5>
                        <p class="card-text">Próximamente</p>
                        <div class="progress mt-auto">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            <span class="progress-label" style="color: black;">Progreso 0%</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Agrega más tarjetas aquí si es necesario -->
        </div>
    </div>
    
</div>
 

    </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href)
            }
        </script>
</body>

</html>
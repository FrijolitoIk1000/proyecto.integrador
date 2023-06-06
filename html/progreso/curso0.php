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
    <title>Cybersafe Educa</title>
    <link rel="stylesheet" href="../../../styles/kali.css">
    <link rel="icon" href="../../../images/favicon.ico" type="image/x-icon">
</head>

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
            <a class="nav-link" href="../html/login.html">Ingreso</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="../html/register.html">Registro</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
          <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Busqueda</button> 
        </form>
      </div>
    </nav>
  </section>
  
  <section id="course">
    <div class="container-course">
      <div class="course-content">
        <h1>¿Qué es Kali Linux?</h1>
          <iframe width="690" height="450" src="https://www.youtube.com/embed/GbxpzonOl7U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

        <div class="module-info">
        <p>Duración estimada: 1 sesión (2 horas)</p>
        <h3>Introducción</h3>
        <p>En este módulo, nos sumergiremos en el fascinante mundo de Kali Linux, una distribución de Linux especializada en seguridad informática y pruebas de penetración. 
            Kali Linux se ha convertido en una herramienta fundamental para los profesionales y entusiastas de la seguridad,ya que ofrece una amplia gama de herramientas y 
            recursos para llevar a cabo auditorías de seguridad, identificar vulnerabilidades y proteger sistemas.</p>
        <h3>Objetivos</h3>
        <p>Fases de reconocimiento en pruebas de penetración</p>
            <li>Visión general de las fases típicas en una prueba de penetración.</li>
            <li>Enfoque en la fase de recopilación de información y su importancia para las etapas posteriores.</li>
        <p>Herramientas de recopilación de información</p>
            <li>Descripción de las herramientas populares utilizadas en la recopilación de información, como Nmap, Recon-ng, TheHarvester, entre otras.</li>
            <li>Uso de técnicas de búsqueda en fuentes públicas y pasivas para obtener información valiosa.</li>  
        <p>Identificación de servicios y sistemas</p>
        <li>Escaneo de puertos y descubrimiento de servicios activos en un objetivo.</li>  
        <li>Utilización de herramientas de escaneo de puertos, como Nmap, para identificar puertos abiertos y servicios en ejecución.</li>  
        <p> Escaneo de puertos y detección de vulnerabilidades</p>
        <li>Interpretación de los resultados del escaneo de puertos y análisis de los servicios encontrados.</li>  
        <li>Detección de vulnerabilidades conocidas en servicios específicos mediante el uso de bases de datos y herramientas de análisis.</li>  
        <h3>Recursos adicionales</h3>
        <li>Documentación oficial de Nmap: <a href="https://nmap.org/docs.html">https://nmap.org/docs.html</a></li>
        <li>Recursos en línea recomendados para aprender más sobre técnicas de recopilación de información y escaneo de puertos.</li>
        </div>
      </div>
      <div class="btn-container">
        <a href="progreso_academico.php?id_usuario=<?php echo $id_usuario; ?>" class="btn btn-primary">&larr; Volver</a>
        <a href="curso1.php?id_usuario=<?php echo $id_usuario; ?>" class="btn btn-primary">Empezar Certificación &rarr;</a>
      </div>
    </div>
</section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
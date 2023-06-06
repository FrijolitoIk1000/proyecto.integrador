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

// Consultar la columna id_subscripcion en la tabla usuarios
$query = "SELECT id_subscripcion FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_subscripcion = $row['id_subscripcion'];
} else {
    // Si no se encontró ningún registro, puedes manejar el caso de error de alguna manera específica
    $id_subscripcion = 0; // Por ejemplo, se asigna un valor predeterminado de 0
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
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
  <title>Cybersafe Educa</title>
  <link rel="stylesheet" href="../../styles/quiz.css">
  <link rel="icon" href="../../images/favicon.ico" type="image/x-icon">
  <style>
  .cajon {
    color: black;
  }
</style>
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
  <?php if ($id_subscripcion == 1): ?>
  <div class="alert alert-warning text-center" role="alert">
    Ya has pasado las preguntas de prueba. Por favor, compra una membresía para continuar y certificar.
  </div>
  <script>
    // Deshabilitar todos los clics en la página
    document.addEventListener('click', function(event) {
      event.preventDefault();
    });
    
    // Redireccionar después de mostrar el aviso
    setTimeout(function() {
      window.location.href = "../panel.php";
    }, 3000); // 3000 milisegundos = 3 segundos
  </script>
<?php endif; ?>
  
  <section id="quiz">
    <div class="wrapper bg-white rounded">
      <div class="content">
        <p class="text-justify h5 pb-2 font-weight-bold">¿Qué se puede lograr mediante el escaneo de puertos en una prueba de penetración?</p>
        <div class="options py-3">
          <label class="rounded p-2 option" onclick="showPositiveFeedback(); disableOptions(); enableButton()">
            <span class="cajon">a) Identificar vulnerabilidades en servicios específicos.</span>
            <input type="radio" name="radio" onclick="showPositiveFeedback(); disableOptions(); enableButton()">
            <span class="checkmark"></span>
          </label>
          <label class="rounded p-2 option">
            <span class="cajon">b) Obtener credenciales de usuario.</span>
            <input type="radio" name="radio" onclick="showNegativeFeedback(); disableOptions(); enableButton()">
            <span class="crossmark"></span>
          </label>
          <label class="rounded p-2 option">
            <span class="cajon">c) Realizar un análisis de riesgos.</span>
            <input type="radio" name="radio" onclick="showNegativeFeedback(); disableOptions(); enableButton()">
            <span class="crossmark"></span>
          </label>
          <label class="rounded p-2 option">
            <span class="cajon">d) Descubrir la dirección IP del objetivo.</span>
            <input type="radio" name="radio" onclick="showNegativeFeedback(); disableOptions(); enableButton()">
            <span class="crossmark"></span>
          </label>
        </div>
        <div id="positive-feedback" style="display: none;">
          <b>Feedback</b>
          <p class="mt-2 mb-4 pl-2 text-justify">
            ¡Respuesta correcta!
          </p>
        </div>
        <div id="negative-feedback" style="display: none;">
          <b>Feedback</b>
          <p class="my-2 pl-2">
            Respuesta incorrecta
          </p>
        </div>
      </div>
      <input id="next-question-btn" type="submit" value="Siguiente Pregunta" class="mx-sm-0 mx-1" disabled>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <script>
    function showPositiveFeedback() {
      document.getElementById("positive-feedback").style.display = "block";
      document.getElementById("negative-feedback").style.display = "none";
    }

    function showNegativeFeedback() {
      document.getElementById("positive-feedback").style.display = "none";
      document.getElementById("negative-feedback").style.display = "block";
    }

    function disableOptions() {
      var options = document.getElementsByClassName("option");
      for (var i = 0; i < options.length; i++) {
        options[i].onclick = null; // Deshabilitar clic
        options[i].getElementsByTagName("input")[0].disabled = true;
      }
    }
    function saveVariablesInDatabase(variable1, variable2) {
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          // Aquí puedes realizar acciones adicionales después de guardar las variables en la base de datos
          console.log("Variables guardadas en la base de datos");
        }
      };

      xhttp.open("POST", "guardar_variable.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("variable1=" + variable1 + "&variable2=" + variable2);
    }

    function redirectToNextPage() {
      var feedbackStyle = document.getElementById("negative-feedback").style.display;

      // Realizar la verificación del estilo
      if (feedbackStyle === "block") {
        var id_usuario = "<?php echo $id_usuario; ?>";
        saveVariablesInDatabase(0, id_usuario);
        window.location.href = "../panel.php";
      }
      else {
        var id_usuario = "<?php echo $id_usuario; ?>";
        saveVariablesInDatabase(60, id_usuario);
        window.location.href = "curso60.php?id_usuario=" + id_usuario;
      }
    }

  function enableButton() {
    document.getElementById("next-question-btn").disabled = false;
  }

  // Evento onclick para el botón "Siguiente Pregunta"
  document.getElementById("next-question-btn").onclick = function() {
    redirectToNextPage();
  };
  if (typeof history.pushState === 'function') {
      history.pushState(null, null, location.href);
      window.onpopstate = function () {
        history.go(1);
      };
    }
  </script>
</body>

</html>
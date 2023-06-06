<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Subscripción CYBERSAFE</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
</head>

<body>
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="panel.php">
                <img src="../images/main-logo.png" alt="texto alternativo de la imagen">
                Volver a Panel Cybersafe
            </a>

            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </nav>
    </section>

    <div class="container-login">
        <div class="border" style="padding: 25px;">

            <h1>MAESTRÍA CYBERSAFE - CONTRARRELOJ</h1>
            <h4 style="padding: 10px;">Aplicación de todos los conceptos para un mejor logro académico</h4>
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


            $sql = "SELECT maestria_usuario FROM maestria WHERE id_usuario = $id_usuario AND maestria_usuario != 0";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $maestria_usuario = $row['maestria_usuario'];
                if ($maestria_usuario == 1) {
                    echo '<div style="display: flex; justify-content: center;">Intento de Maestría Fallida</div>';
                } elseif ($maestria_usuario == 2) {
                    echo '<div style="display: flex; justify-content: center; color: blue;">MAESTRÍA OBTENIDA - CYBERSAFE EDUCA</div>';
                    echo '<img style="display: block; margin: 0 auto;" src="../images/main-logo.png" alt="texto alternativo de la imagen">';
                }
            }
            else{
                // Obtener el progreso del usuario desde la tabla "progreso"
                $query = "SELECT progreso_curso1 FROM progreso WHERE id_usuario = $id_usuario";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $progreso_curso1 = $row['progreso_curso1'];

                    if ($progreso_curso1 == 100) {
                        echo '<a style="display: flex; justify-content: center; font-weight: bold;" href="maestria_quiz.php?id_usuario='.$id_usuario.'">Empezar maestría</a>';
                        $sql = "SELECT id_usuario FROM maestria WHERE id_usuario = $id_usuario";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows == 0) {
                            // El id_usuario no existe en la tabla "maestria"
                            // Insertar el nuevo registro con valores iniciales
                            $sql = "INSERT INTO maestria (id_usuario, maestria_usuario) VALUES ($id_usuario, 0)";
                            if ($conn->query($sql) === TRUE) {
                                // Continuar con el resto del código o redirigir a otra página
                            } else {
                                echo "Error al insertar en la tabla maestria: " . $conn->error;
                            }
                        }
                    } else {
                        echo 'Usted no posee el certificado necesario para hacer el máster.';
                    }
                } else {
                    // Mostrar mensaje si no se encuentra el registro de progreso
                    echo '<h2>No se encontró el registro de progreso</h2>';
                }
            }

            $conn->close();
            ?>

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

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
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .certificate {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            margin-top: -90px;
        }

        .certificate h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .certificate p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .certificate img {
            width: 200px;
            margin-bottom: 20px;
        }
    </style>
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

            <?php
            session_start();

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;

            require 'C:/xampp/htdocs/html/PHPMailer/src/Exception.php';
            require 'C:/xampp/htdocs/html/PHPMailer/src/PHPMailer.php';
            require 'C:/xampp/htdocs/html/PHPMailer/src/SMTP.php';

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

            // Obtener el progreso del usuario desde la tabla "progreso"
            $id_usuario = $_GET['id_usuario'];
            $query = "SELECT progreso_curso1 FROM progreso WHERE id_usuario = $id_usuario";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $progreso_curso1 = $row['progreso_curso1'];

                if ($progreso_curso1 == 100) {
                    // Obtener el nombre y apellido del usuario desde la tabla "usuarios"
                    $query_usuario = "SELECT correo_usuario, nombre_usuario, apellido_usuario FROM usuarios WHERE id_usuario = $id_usuario";
                    $result_usuario = $conn->query($query_usuario);

                    if ($result_usuario && $result_usuario->num_rows > 0) {
                        $row_usuario = $result_usuario->fetch_assoc();
                        $correo_usuario = $row_usuario['correo_usuario'];
                        $nombre_usuario = $row_usuario['nombre_usuario'];
                        $apellido_usuario = $row_usuario['apellido_usuario'];

                        // Obtener la fecha actual
                        $fecha_actual = date("Y-m-d");

                        // Mostrar imagen y título "CERTIFICADOS" si el progreso es 100
                        echo '<div class="certificate">
                            <img src="../images/main-logo.png" alt="Diploma">
                            <h1>Certificado Académico</h1>
                            <p>Se certifica que <strong>' . $nombre_usuario . ' ' . $apellido_usuario . '</strong> ha completado el curso de <strong>KALI LINUX</strong> con éxito.</p>
                            <p>Fecha: <strong>' . $fecha_actual . '</strong></p>
                            <p>Firma: Diego Agudelo Pentester CYBERSAFE EDUCA</p>
                        </div>';
                    }
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $to = $correo_usuario;
                        $fechaActual = date('Y-m-d H:i:s');

                        $subject = 'ACTA CERTIFICADO KALI LINUX - CYBERSAFE EDUCA';

                        $message = '<html><head><h1>CERTIFICADO ACADEMICO KALI LINUX</h1></head><body><div class="certificate">
                            <a href="https://imgbb.com/"><img src="https://i.ibb.co/VVCbVPf/main-logo.png" alt="main-logo" border="0"></a>
                            <h1>Certificado Académico</h1>
                            <p>Se certifica que <strong>' . $nombre_usuario . ' ' . $apellido_usuario . '</strong> ha completado el curso de <strong>KALI LINUX</strong> con éxito.</p>
                            <p>Fecha: <strong>' . $fecha_actual . '</strong></p>
                            <p>Firma: Diego Agudelo Pentester CYBERSAFE EDUCA</p>
                        </div></body></html>';
                        
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

                        // Establecer las cabeceras para enviar el correo con formato HTML
                        $mail->isHTML(true);
                        $mail->AltBody = 'Por favor, utiliza un cliente de correo con capacidad HTML para ver este mensaje';

                        // Enviar el correo
                        if ($mail->send()) {
                            echo '<div class="message" style="background-color: #4CAF50; color: white; padding: 10px; border-radius: 3px; margin-bottom: 10px;">Certificado enviado al correo enviado con éxito a: ' . $correo_usuario . '</div>';
                        } else {
                            echo '<div class="message" style="background-color: #FF0000; color: white; padding: 10px; border-radius: 3px; margin-bottom: 10px;">Error al enviar el correo.</div>';
                        }
                    }
                } else {
                    // Mostrar mensaje si no se tienen certificados
                    echo '<h2>Usted no posee certificados</h2>';
                }
            } else {
                // Mostrar mensaje si no se encuentra el registro de progreso
                echo '<h2>No se encontró el registro de progreso</h2>';
            }

            if($progreso_curso1 == 100) {
                echo '
                <div style="text-align: center; padding-top: 20px;">
                    <form method="POST" action="certificacion.php?id_usuario='.$id_usuario.'">
                        <button type="submit" class="btn btn-primary">Enviar Acta al correo</button>
                    </form>
                </div>';
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

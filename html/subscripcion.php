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

        $usuario = $_SESSION['correo'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedSubscription = $_POST['suscripcion'];

            if ($selectedSubscription == "Suscripción A") {
                $subscriptionId = 2; // Assuming subscription ID 2 represents PREMIUM
            } elseif ($selectedSubscription == "Suscripción B") {
                $subscriptionId = 3; // Assuming subscription ID 3 represents PENTESTER
            }

            // Update the user's subscription in the database
            $updateQuery = "UPDATE usuarios SET id_subscripcion = '$subscriptionId' WHERE correo_usuario = '$usuario'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Subscription updated successfully, redirect or display a success message
                $to = $usuario;
                $fechaActual = date('Y-m-d H:i:s');

                $subject = 'Compra de Membresia CYBERSAFE EDUCA';
                if ($subscriptionId == 2){
                    $subscriptionName = "PREMIUM";
                }else if ($subscriptionId == 3){
                    $subscriptionName = "PENTESTER";
                }
                $message = 'Hola, felicidades por tu subscripcion a CYBERSAFE EDUCA en la fecha '.$fechaActual.', tu nueva nueva membresia es: '.$subscriptionName.'!!! CYBERSAFE EDUCA :)';
                
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
                header("Location: panel.php"); // Redirect to the panel or desired page
                exit();
            } else {
                echo "Error updating subscription: " . mysqli_error($conn);
            }
        }

        // Consult the user's current subscription
        $consultaSuscripcion = "SELECT id_subscripcion FROM usuarios WHERE correo_usuario = '$usuario'";
        $resultadoTipoSuscripcion = mysqli_query($conn, $consultaSuscripcion);

        if ($resultadoTipoSuscripcion) {
            if (mysqli_num_rows($resultadoTipoSuscripcion) > 0) {
                $filaSuscripcion = mysqli_fetch_assoc($resultadoTipoSuscripcion);
                $idSuscripcion = $filaSuscripcion['id_subscripcion'];

                // Consult the subscription types from the database
                $consultaTipoSuscripcion = "SELECT tipo_subscripcion FROM subscripcion WHERE id_subscripcion = '$idSuscripcion'";
                $resultadoTipoSuscripcion = mysqli_query($conn, $consultaTipoSuscripcion);

                if ($resultadoTipoSuscripcion) {
                    if (mysqli_num_rows($resultadoTipoSuscripcion) > 0) {
                        $filaTipoSuscripcion = mysqli_fetch_assoc($resultadoTipoSuscripcion);
                        $tipoSuscripcionActual = $filaTipoSuscripcion['tipo_subscripcion'];

                        echo '<div style="text-align: center; background-color: #f5f5f5; padding: 10px;">
                            <h3 style="color: #333;">Suscripción actual: <span style="color: #007FE3;">' . $tipoSuscripcionActual . '</span></h3>
                        </div>';
                    } else {
                        echo "No se encontraron resultados para la consulta de tipo de suscripción.";
                    }
                } else {
                    echo "Error en la consulta de tipo de suscripción: " . mysqli_error($conn);
                }
            } else {
                echo "No se encontraron resultados para la consulta de suscripción.";
            }
        } else {
            echo "Error en la consulta de suscripción: " . mysqli_error($conn);
        }


        if ($idSuscripcion >= 2) {
            echo '
            <div style="text-align: center; padding-top: 20px;">
                <h3>Cancelar suscripción:</h3>
                <form method="POST" action="cancelar_subscripcion.php">
                    <button type="submit" class="btn btn-danger">Cancelar suscripción</button>
                </form>
            </div>';
        } else {
            echo '
            <h3 style="text-align: center; padding: 10px;">Comprar otras suscripciones:</h3>
            <form method="POST" action="subscripcion.php">
                <div class="form-group">
                    <label for="suscripcion">Seleccione una suscripción:</label>
                    <select class="form-control" id="suscripcion" name="suscripcion">
                        <option value="Suscripción A">PREMIUM</option>
                        <option value="Suscripción B">PENTESTER</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Comprar</button>
            </form>';
        }
        mysqli_close($conn);
        ?>


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
<!DOCTYPE html>
<html lang="es"></html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maestría CYBERSAFE</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        input[type="text"] {
            font-size: 1rem;
            padding: 0.25rem;
            width: 2rem;
            text-align: center;
            margin-right: 1rem;
        }
        button {
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            font-size: 1.25rem;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .progress {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .progress-bar {
            height: 1rem;
            background-color: #007bff;
            border-radius: 5px;
        }
    </style>

<script>
        function validarLetra(input) {
            const regex = /^[A-Za-zñÑ]+$/;
            if (!input.value.match(regex)) {
                input.setCustomValidity('Por favor, ingrese solo letras (A-Z).');
            } else {
                input.setCustomValidity('');
            }
        }
        if (typeof history.pushState === 'function') {
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.go(1);
            };
        }
</script>
</head>

<body>
    <?php
        session_start();
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        require 'C:/xampp/htdocs/html/PHPMailer/src/Exception.php';
        require 'C:/xampp/htdocs/html/PHPMailer/src/PHPMailer.php';
        require 'C:/xampp/htdocs/html/PHPMailer/src/SMTP.php';
        
    ?>
    <div style="display: inline;">
        <h1 style="font-weight: bold;margin-bottom:20px; display: flex; justify-content: center;">MAESTRÍA KALI LINUX - CYBERSAFE EDUCA</h1>
        <div class="container">
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

                if (!isset($_SESSION['correo'])) {
                    header("Location: login.php");
                    exit();
                }
                $id_usuario = $_GET['id_usuario'];
                if (!isset($_SESSION['palabras'])) {
                    $_SESSION['palabras'] = ['vulnerable', 'seguridad', 'auditoria'];
                    $_SESSION['info'] = ['Que es susceptible o propenso a ser atacado o explotado debido a debilidades en su seguridad o protección.', 'Conjunto de medidas y precauciones tomadas para proteger un sistema, red o información contra posibles amenazas o ataques.', 'Un examen sistemático y detallado de los registros, procesos y controles de un sistema, con el fin de evaluar su eficacia, identificar problemas y garantizar el cumplimiento de estándares y regulaciones.'];
                    $_SESSION['info_palabra'] = $_SESSION['info'][0];
                    $_SESSION['cont'] = 0;
                }

                if (!isset($_SESSION['palabra'])) {
                    $_SESSION['palabra'] = array_shift($_SESSION['palabras']);
                    $_SESSION['letras'] = preg_replace('/[a-z]/i', '_', $_SESSION['palabra']);
                    $_SESSION['intentos'] = 0;
                }

                if (isset($_POST['timeIsUp']) && $_POST['timeIsUp'] === 'true') {
                    $_SESSION['intentos'] = 4;
                }

                if (isset($_POST['letra'])) {
                    $letra = strtolower($_POST['letra']);
                    $temp = '';
                    for ($i = 0; $i < strlen($_SESSION['palabra']); $i++) {
                        if ($_SESSION['palabra'][$i] === $letra) {
                            $temp .= $letra;
                        } else {
                            $temp .= $_SESSION['letras'][$i];
                        }
                    }

                    if ($_SESSION['letras'] === $temp) {
                        $_SESSION['intentos']++;
                    } else {
                        $_SESSION['letras'] = $temp;
                    }
                    if ($_SESSION['letras'] === $_SESSION['palabra']) {
                        echo '<h1>¡Ganaste un 5.0! La palabra era: ' . $_SESSION['palabra'] . '</h1>';
                        if (!empty($_SESSION['palabras'])) {
                            $_SESSION['cont'] = $_SESSION['cont'] + 1;
                            $_SESSION['info_palabra'] = $_SESSION['info'][$_SESSION['cont']];
                            $_SESSION['palabra'] = array_shift($_SESSION['palabras']);
                            $_SESSION['letras'] = preg_replace('/[a-z]/i', '_', $_SESSION['palabra']);
                            $_SESSION['intentos'] = 0;
                        } else {
                            unset($_SESSION['palabra'], $_SESSION['letras'], $_SESSION['intentos'], $_SESSION['palabras'], $_SESSION['info_palabra'], $_SESSION['info']);
                        }
                        $sql = "UPDATE maestria SET maestria_usuario = 2 WHERE id_usuario = $id_usuario";
                        if ($conn->query($sql) === TRUE) {
                            // Continuar con el resto del código o redirigir a otra página
                        } else {
                            echo "Error al actualizar la tabla maestria: " . $conn->error;
                        }
                    } elseif ($_SESSION['intentos'] >= 4) {
                        echo '<h1>Tu nota es: '.round($_SESSION['aux'], 1).' La palabra era: ' . $_SESSION['palabra'] . '</h1>';
                        if (!empty($_SESSION['palabras'])) {
                            $_SESSION['cont'] = $_SESSION['cont'] + 1;
                            $_SESSION['info_palabra'] = $_SESSION['info'][$_SESSION['cont']];
                            $_SESSION['palabra'] = array_shift($_SESSION['palabras']);
                            $_SESSION['letras'] = preg_replace('/[a-z]/i', '_', $_SESSION['palabra']);
                            $_SESSION['intentos'] = 0;
                        } else {
                            unset($_SESSION['palabra'], $_SESSION['letras'], $_SESSION['intentos'], $_SESSION['palabras'], $_SESSION['info_palabra'], $_SESSION['info']);
                        }
                        if ($_SESSION['aux'] < 3.0) {
                            // Realizar acciones si $progress es menor a 3.0
                            // Por ejemplo, actualizar el valor en la tabla "maestria" a 0
                            $sql = "UPDATE maestria SET maestria_usuario = 1 WHERE id_usuario = $id_usuario";
                            if ($conn->query($sql) === TRUE) {
                                unset($_SESSION['palabra'], $_SESSION['letras'], $_SESSION['intentos'], $_SESSION['palabras'], $_SESSION['info_palabra'], $_SESSION['info']);
                                header("Location: maestria.php?id_usuario=$id_usuario");
                                exit();
                            } else {
                                echo "Error al actualizar la tabla maestria: " . $conn->error;
                            }
                        } else if($_SESSION['aux'] >= 3.0) {
                            // Realizar acciones si $progress es mayor o igual a 3.0
                            // Por ejemplo, actualizar el valor en la tabla "maestria" a 1
                            $sql = "UPDATE maestria SET maestria_usuario = 2 WHERE id_usuario = $id_usuario";
                            if ($conn->query($sql) === TRUE) {
                                // Continuar con el resto del código o redirigir a otra página
                            } else {
                                echo "Error al actualizar la tabla maestria: " . $conn->error;
                            }
                        }
                    }
                }
                $progress = 0.0;
                $progresoBarra = 0;
                if (isset($_SESSION['palabra']) && isset($_SESSION['letras'])) {
                    echo '<h1>'.$_SESSION['info_palabra'].'</h1>';
                    $totalLetters = strlen(preg_replace('/[^a-z]/i', '', $_SESSION['palabra']));
                    $discoveredLetters = strlen(preg_replace('/[_\s]/', '', $_SESSION['letras']));
                    $progresoBarra = ($discoveredLetters / $totalLetters) * 100;
                    $progress = ($discoveredLetters / $totalLetters) * 100;
                    $progress = ($progress * 5.0) / 100;
                    $_SESSION['aux'] = $progress;
                }
            ?>

            <?php if (isset($_SESSION['letras'])): ?>
                <h2>Intentos restantes: <?php echo 4 - $_SESSION['intentos']; ?></h2>
                <p><?php echo implode(' ', str_split($_SESSION['letras'])); ?></p>
                <form method="POST">
                    <input type="hidden" id="timeIsUp" name="timeIsUp" value="false">
                    <input type="text" name="letra" maxlength="1" required autocomplete="off" oninput="validarLetra(this);">
                    <button type="submit">Enviar letra</button>
                </form>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo $progresoBarra;?>%;"></div>
                </div>
                <p>Progreso: <?php echo round($progress, 1); ?></p>
                
            <?php else: ?>
                <a href="maestria.php?id_usuario=<?php echo $id_usuario; ?>">Volver al panel de maestría</a>
                <?php
                    $sql = "SELECT correo_usuario FROM usuarios WHERE id_usuario = '$id_usuario'";
                    $resultado = $conn->query($sql);
                    if ($resultado->num_rows > 0) {
                        $row = $resultado->fetch_assoc();
                        $correo_usuario = $row["correo_usuario"];
                    }
                    $to = $correo_usuario;
                    $fechaActual = date('Y-m-d H:i:s');
            
                    $subject = 'OBTENCION MAESTRIA - CYBERSAFE EDUCA';

                    $message = 'Haz obtenido la MAESTRIA KALI LINUX con CYBERSAFE EDUCA en la fecha '.$fechaActual.', celebramos tu logro con mucho entusiasmo. Felicidades por tu esfuerzo!';
                    
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
                        echo '<div class="message" style="background-color: #4CAF50; color: white; padding: 10px; border-radius: 3px; margin-bottom: 10px;">Notificación enviada con éxito a: ' . $to . '</div>';
                    }
                    $conn->close();
                ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
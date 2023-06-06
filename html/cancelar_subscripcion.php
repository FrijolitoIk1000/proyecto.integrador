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

// Check if the cancel subscription button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the user's subscription to a default value (assuming 1 represents BASIC)
    $updateQuery = "UPDATE usuarios SET id_subscripcion = 1 WHERE correo_usuario = '$usuario'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Subscription canceled successfully, redirect or display a success message
        $to = $usuario;
        $fechaActual = date('Y-m-d H:i:s');

        $subject = 'Cancelacion MEMBRESIA CYBERSAFE EDUCA';

        $message = 'Hola, has cancelado tu subscripcion en CYBERSAFE EDUCA en la fecha '.$fechaActual.', la proxima compra la subscripcion PENTESTER ;)';
                
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
        echo "Error canceling subscription: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
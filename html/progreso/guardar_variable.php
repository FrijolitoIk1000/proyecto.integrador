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

// Verificar la conexión a la base de datos
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener el valor de la variable "x" enviada a través de AJAX
$variable1 = $_POST["variable1"];
$variable2 = $_POST["variable2"];

// Escapar el valor para prevenir inyección de SQL
$variable1 = $conn->real_escape_string($variable1);
$variable2 = $conn->real_escape_string($variable2);

// Construir la consulta SQL para actualizar el campo "progreso_curso1" en la tabla "progreso"
$sql = "UPDATE progreso SET progreso_curso1 = '$variable1' WHERE id_usuario = '$variable2'";

// Ejecutar la consulta y verificar si tuvo éxito
if ($conn->query($sql) === TRUE) {
    echo "Variable guardada en la base de datos";
    if ($variable1 == '100'){
        $sql = "SELECT correo_usuario FROM usuarios WHERE id_usuario = '$variable2'";
        $resultado = $conn->query($sql);
        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $correo_usuario = $row["correo_usuario"];
        }
        $to = $correo_usuario;
        $fechaActual = date('Y-m-d H:i:s');

        $subject = 'CERTIFICACION COMPLETADA - CYBERSAFE EDUCA';

        $message = 'Haz obtenido la Certificacion KALI LINUX con CYBERSAFE EDUCA en la fecha '.$fechaActual.', ve por la maestria! (Debes tener la membresia PENTESTER)';
        
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
        if ($mail->send()) {
        }
    }
} else {
    echo "Error al guardar la variable en la base de datos: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
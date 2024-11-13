<?php

// Verificar que los valores del formulario no vengan vacíos
$numero = filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);

if (!$correo || empty($nombre) || empty($numero)) {
    echo "Por favor, completa todos los campos correctamente.";
    exit;
}

// Importar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// Configurar PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'webcotizaciones@bagumedios.com';
    $mail->Password   = 'WebBagu2024*';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Destinatario y contenido
    $mail->setFrom('webcotizaciones@bagumedios.com', 'BAGU MEDIOS SAS');
    $mail->addAddress($correo, $nombre);
    $mail->isHTML(true);
    $mail->Subject = 'COTIZACION PROCESADA';
    $mail->Body    = "Este es el contenido en HTML para: $nombre";

    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo "El mensaje no se pudo enviar. Error de Mailer: {$mail->ErrorInfo}";
}
?>

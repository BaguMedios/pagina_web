<?php
// Verificar que los valores del formulario no vengan vacíos
$numero = filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);

// Verificar que los valores requeridos no estén vacíos
if (!$correo || empty($nombre) || empty($numero)) {
    echo "Por favor, completa todos los campos correctamente.";
    exit;
}

// Leer el contenido de las plantillas de correo HTML
$template_path = '../mail/mail_cliente.html';
$template_path_2 = '../mail/mail_operador.html';
$email_template = file_get_contents($template_path);
$email_template_2 = file_get_contents($template_path_2);

// Reemplazar valores con el nombre dinámico en ambas plantillas
$email_content = str_replace('{{nombre}}', $nombre, $email_template);
$email_content_2 = str_replace(
    ['{{nombre}}', '{{correo}}', '{{numero}}'],
    [$nombre, $correo, $numero],
    $email_template_2
);

// Importar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

// Iniciar el bloque try-catch
try {
    // Configurar PHPMailer para el correo al operador
    $mail2 = new PHPMailer(true);
    $mail2->isSMTP();
    $mail2->Host = 'smtp.hostinger.com';
    $mail2->SMTPAuth = true;
    $mail2->Username = 'webcotizaciones@bagumedios.com';
    $mail2->Password = 'WebBagu2024*';
    $mail2->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail2->Port = 465;

    // Configuración del remitente y destinatarios del operador
    $mail2->setFrom('webcotizaciones@bagumedios.com', 'NUEVO CLIENTE BAGU MEDIOS');
    $mail2->addAddress('santiago@bagumedios.com', 'Santiago');
    $mail2->addAddress('mediosads@bagumedios.com', 'Diego');
    $mail2->addAddress('paola.gomez@bagumedios.com', 'Paola');
    $mail2->addAddress('auxiliar_contable@bagumedios.com', 'Laura');

    // Configuración del contenido del correo al operador
    $mail2->isHTML(true);
    $mail2->Subject = 'NUEVO CLIENTE PAGINA WEB';
    $mail2->Body = $email_content_2;
    $mail2->send();

    // Configurar PHPMailer para el correo al cliente
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'webcotizaciones@bagumedios.com';
    $mail->Password = 'WebBagu2024*';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    // Configuración del remitente y destinatario del cliente
    $mail->setFrom('webcotizaciones@bagumedios.com', 'BAGU MEDIOS SAS');
    $mail->addAddress($correo, $nombre);

    // Configuración del contenido del correo al cliente
    $mail->isHTML(true);
    $mail->Subject = 'COTIZACION PROCESADA';
    $mail->Body = $email_content;

    // Enviar el correo al cliente
    $mail->send();

    // Redirigir después de enviar
    echo '<script>alert("La información fue enviada correctamente"); window.location.href = "../Agradecimiento.php";</script>';

} catch (Exception $e) {
    echo "El mensaje no se pudo enviar. Error de Mailer: {$mail->ErrorInfo}";
}
?>

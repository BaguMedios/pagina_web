<?php
// ================================
// Verificación de reCAPTCHA v3
// ================================

// Verificar que se haya enviado el token de reCAPTCHA
if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
    echo "Error: No se recibió el token de reCAPTCHA.";
    exit;
}

$recaptchaResponse = $_POST['g-recaptcha-response'];
$secretKey = '6LefM9wqAAAAAPyiWzloDFsDT8BQzSJvQ3RWNkqN';
$remoteIp = $_SERVER['REMOTE_ADDR'];
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

// Preparar datos para la verificación
$data = [
    'secret'   => $secretKey,
    'response' => $recaptchaResponse,
    'remoteip' => $remoteIp
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($recaptchaUrl, false, $context);
$result = json_decode($response, true);

// Para depuración, puedes descomentar estas líneas y verificar la respuesta:
// echo "<pre>";
// print_r($result);
// echo "</pre>";
// exit;

$umbral = 0.3; // Umbral de puntuación para pruebas

if (!$result['success'] || $result['score'] < $umbral) {
    echo "Error: La verificación de reCAPTCHA falló. Por favor, inténtalo de nuevo.";
    exit;
}

// ================================
// Procesamiento de los datos del formulario
// ================================

$numero      = filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
$nombre      = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$correo      = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
$servicio    = isset($_POST['servicio']) ? filter_var($_POST['servicio'], FILTER_SANITIZE_STRING) : "";
$informacion = isset($_POST['informacion']) ? filter_var($_POST['informacion'], FILTER_SANITIZE_STRING) : "";

// Validar que los campos requeridos no estén vacíos
if (!$correo || empty($nombre) || empty($numero)) {
    echo "Por favor, completa todos los campos correctamente.";
    exit;
}

// ================================
// Preparar el contenido de los correos
// ================================

$template_path   = '../mail/mail_cliente.html';
$template_path_2 = '../mail/mail_operador.html';

if (!file_exists($template_path) || !file_exists($template_path_2)) {
    echo "Error: No se encontraron las plantillas de correo.";
    exit;
}

$email_template   = file_get_contents($template_path);
$email_template_2 = file_get_contents($template_path_2);

// Reemplazar los placeholders en las plantillas
$email_content = str_replace('{{nombre}}', $nombre, $email_template);
$email_content_2 = str_replace(
    ['{{nombre}}', '{{correo}}', '{{numero}}', '{{servicio}}', '{{informacion}}'],
    [$nombre, $correo, $numero, $servicio, $informacion],
    $email_template_2
);

// ================================
// Enviar los correos con PHPMailer
// ================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

try {
    // Correo al operador
    $mail2 = new PHPMailer(true);
    $mail2->isSMTP();
    $mail2->Host       = 'smtp.hostinger.com';
    $mail2->SMTPAuth   = true;
    $mail2->Username   = 'webcotizaciones@bagumedios.com';
    $mail2->Password   = 'WebBagu2024*';
    $mail2->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail2->Port       = 465;

    $mail2->setFrom('webcotizaciones@bagumedios.com', 'NUEVO CLIENTE BAGU MEDIOS');
    $mail2->addAddress('santiago@bagumedios.com', 'Santiago');
    $mail2->addAddress('mediosads@bagumedios.com', 'Diego');
    $mail2->addAddress('paola.gomez@bagumedios.com', 'Paola');
    $mail2->addAddress('auxiliar_contable@bagumedios.com', 'Laura');
    $mail2->addAddress('gerencia@bagumedios.com','wilmar');
    $mail2->addAddress('direccion.comercial@bagumedio.com','anyela');

    $mail2->isHTML(true);
    $mail2->Subject = 'NUEVO CLIENTE PAGINA WEB';
    $mail2->Body    = $email_content_2;
    $mail2->send();

    // Correo al cliente
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'webcotizaciones@bagumedios.com';
    $mail->Password   = 'WebBagu2024*';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('webcotizaciones@bagumedios.com', 'BAGU MEDIOS SAS');
    $mail->addAddress($correo, $nombre);

    $mail->isHTML(true);
    $mail->Subject = 'COTIZACION PROCESADA';
    $mail->Body    = $email_content;
    $mail->send();

    // Redirigir a la página de agradecimiento
    echo '<script> window.location.href = "../Agradecimiento.php";</script>';
} catch (Exception $e) {
    echo "El mensaje no se pudo enviar. Error de Mailer: {$mail->ErrorInfo}";
}
?>


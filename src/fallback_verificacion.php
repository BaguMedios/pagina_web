<?php
// Incluimos la conexión con la base de datos
include('../SQL/conexion.php');

// Verificar que se haya enviado el token de reCAPTCHA v2
if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
    echo "Error: No se recibió el token de reCAPTCHA v2.";
    exit;
}

$recaptchaResponseV2 = $_POST['g-recaptcha-response'];
// Clave secreta de reCAPTCHA v2 (la que nos proporcionaste)
$secretKeyV2 = '6LeJYt4qAAAAAJLJL0rnV7WHWZA5gupntr0siPyX';
$remoteIp = $_SERVER['REMOTE_ADDR'];
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

$data = [
    'secret'   => $secretKeyV2,
    'response' => $recaptchaResponseV2,
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

if (!$result['success']) {
    echo "Error: La verificación de reCAPTCHA v2 falló. Por favor, inténtalo de nuevo.";
    exit;
}

// ================================
// Procesamiento de los datos del formulario (si reCAPTCHA v2 es exitoso)
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

// Inserción en la base de datos
$stmt = $conn->prepare("INSERT INTO `cotizaciones_web` (`nombre`, `correo`, `numero`, `servicio`, `informacion`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $correo, $numero, $servicio, $informacion);
$stmt->execute();
$stmt->close();

// Aquí puedes repetir el proceso de envío de correos o redirigir a la página de agradecimiento
echo '<script> window.location.href = "../Agradecimiento.php";</script>';
?>

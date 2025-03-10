<?php
// Incluimos la conexión con la base de datos
include('../SQL/conexion.php');

// ================================
// Verificación de reCAPTCHA v3
// ================================

// Verificar que se haya enviado el token de reCAPTCHA v3
if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
    echo "Error: No se recibió el token de reCAPTCHA.";
    exit;
}

$recaptchaResponse = $_POST['g-recaptcha-response'];
// Clave secreta de reCAPTCHA v3 (ya establecida en tu código)
$secretKeyV3 = '6LefM9wqAAAAAPyiWzloDFsDT8BQzSJvQ3RWNkqN';
$remoteIp = $_SERVER['REMOTE_ADDR'];
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

// Preparar datos para la verificación
$data = [
    'secret'   => $secretKeyV3,
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

// Para depuración, puedes descomentar estas líneas:
// echo "<pre>";
// print_r($result);
// echo "</pre>";
// exit;

$umbral = 0.5; // Umbral de puntuación

if (!$result['success'] || $result['score'] < $umbral) {
    // Si la puntuación es baja, se solicita la verificación adicional con reCAPTCHA v2
    echo "Parece que tienes que hacer una verificación adicional. Completa el siguiente captcha:";
    ?>
    <form action="fallback_verificacion.php" method="post">
        <!-- Reenviamos los datos del formulario mediante campos ocultos -->
        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($_POST['nombre']); ?>">
        <input type="hidden" name="correo" value="<?php echo htmlspecialchars($_POST['correo']); ?>">
        <input type="hidden" name="numero" value="<?php echo htmlspecialchars($_POST['numero']); ?>">
        <input type="hidden" name="servicio" value="<?php echo isset($_POST['servicio']) ? htmlspecialchars($_POST['servicio']) : ''; ?>">
        <input type="hidden" name="informacion" value="<?php echo isset($_POST['informacion']) ? htmlspecialchars($_POST['informacion']) : ''; ?>">
        <!-- Widget de reCAPTCHA v2 usando la clave de sitio proporcionada -->
        <div class="g-recaptcha" data-sitekey="6LeJYt4qAAAAAC2A42JXyV-LeORXcWEpZ9fAW5HQ"></div>
        <br>
        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php
    exit;
}

// ================================
// Procesamiento de los datos del formulario (si reCAPTCHA v3 es exitoso)
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

// Preparar la consulta para insertar los datos
$stmt = $conn->prepare("INSERT INTO `cotizaciones_web` (`nombre`, `correo`, `numero`, `servicio`, `informacion`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $correo, $numero, $servicio, $informacion);
$stmt->execute();
$stmt->close();

// Preparar el contenido de los correos
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

// Enviar los correos con PHPMailer
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
    $mail2->addAddress('gerencia@bagumedios.com', 'Wilmar');
    $mail2->addAddress('direccion.comercial@bagumedio.com', 'Anyela');
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



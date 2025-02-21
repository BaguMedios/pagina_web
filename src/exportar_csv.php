<?php
// Forzar el uso de HTTPS (opcional pero recomendado)
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Nombre de usuario y contraseña permitidos
$username = 'BaguIT';
$password = 'BaguMedios2025*';

// Evitar que el navegador almacene las credenciales en caché
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// Solicitar credenciales al usuario
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $username || $_SERVER['PHP_AUTH_PW'] !== $password) {
    header('WWW-Authenticate: Basic realm="Área protegida"');
    header('HTTP/1.0 401 Unauthorized');
    die("Acceso denegado. Debes ingresar las credenciales correctas.");
}

include('../SQL/conexion.php');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta a la tabla cotizaciones
$sql = "SELECT * FROM cotizaciones_web";
$result = $conn->query($sql);

// Encabezados HTTP para CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=cotizaciones.csv');

// Abre la salida estándar como un archivo para escribir
$output = fopen('php://output', 'w');

// Escribe los encabezados de las columnas basados en la estructura de la tabla
fputcsv($output, [
    'nombre', 
    'correo', 
    'numero', 
    'servicio', 
    'informacion'
]);

// Escribe los datos fila por fila
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['nombre'],
            $row['correo'],
            $row['numero'],
            $row['servicio'],
            $row['informacion']
        ]);
    }
}

// Cierra la conexión
$conn->close();
fclose($output);
exit();
?>

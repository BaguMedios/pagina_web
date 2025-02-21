<?php
    // Realizamos la conexión a la base de datos
    $servername = "localhost";
    $username = "u149527708_BaguWeb";
    $password = "BaguMedios2025*";
    $dbname = "u149527708_BaguWeb";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Verificamos si la conexión fue exitosa
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }
?>
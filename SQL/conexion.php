<?php
//Realizamos una conexion con la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "u149527708_bagu_2023";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Verificamos si la conexión fue exitosa
    if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
    }
?>
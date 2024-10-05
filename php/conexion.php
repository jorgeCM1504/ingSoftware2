<?php
$servername = "localhost";
$username = "root";  // Cambia esto por tu usuario de MySQL
$password = "";      // Cambia esto por tu contraseña de MySQL
$database = "parqueadero_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el charset a UTF-8
$conn->set_charset("utf8");
?>

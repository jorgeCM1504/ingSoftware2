<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $placa_vehiculo = $_POST['placa_vehiculo'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, apellido, cedula, placa_vehiculo, tipo_vehiculo, correo, direccion, contrasena)
            VALUES ('$nombre', '$apellido', '$cedula', '$placa_vehiculo', '$tipo_vehiculo', '$correo', '$direccion', '$contrasena')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

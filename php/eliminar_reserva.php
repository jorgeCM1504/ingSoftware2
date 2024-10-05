<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../html/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $reserva_id = $_GET['id'];

    $sql = "DELETE FROM reservas WHERE id = '$reserva_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Reserva eliminada correctamente.";
    } else {
        echo "Error al eliminar la reserva: " . $conn->error;
    }
}

$conn->close();
header("Location: gestionar_reservas.php");
?>

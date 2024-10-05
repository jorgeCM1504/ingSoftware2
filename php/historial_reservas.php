<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener el historial de reservas del usuario
$sql = "SELECT r.*, p.nombre AS parqueadero_nombre 
        FROM reservas r 
        JOIN parqueaderos p ON r.parqueadero_id = p.id 
        WHERE r.usuario_id = '$usuario_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Reservas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Historial de Reservas</h2>

    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
    </ul>

    <table>
        <tr>
            <th>ID</th>
            <th>Parqueadero</th>
            <th>Placa</th>
            <th>Fecha Entrada</th>
            <th>Fecha Salida</th>
            <th>Estancia Min</th>
            <th>Valor</th>
            <th>Estado</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><center><?php echo $row['id']; ?></center></td>
            <td><center><?php echo $row['parqueadero_nombre']; ?></center></td>
            <td><center><?php echo $row['placa_vehiculo']; ?></center></td>
            <td><center><?php echo $row['fecha_entrada']; ?></center></td>
            <td><center><?php echo $row['fecha_salida']; ?></center></td>
            <td><center><?php echo $row['tiempo_estancia']; ?></center></td>
            <td><center><?php echo $row['valor']; ?></center></td>
            <td><center><?php echo $row['estado']; ?></center></td>
        </tr>
        <?php endwhile; ?>
    </table><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

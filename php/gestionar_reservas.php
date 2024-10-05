<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: l../html/ogin.html");
    exit();
}

// Obtener todas las reservas
$sql = "SELECT r.*, u.nombre, u.apellido, p.nombre AS parqueadero_nombre 
        FROM reservas r 
        JOIN usuarios u ON r.usuario_id = u.id 
        JOIN parqueaderos p ON r.parqueadero_id = p.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Reservas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Gestionar Reservas</h2>

    
    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
           
    </ul>




    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Parqueadero</th>
            <th>Placa Vehículo</th>
            <th>Fecha Entrada</th>
            <th>Hora Entrada</th>
            <th>Fecha Salida</th>
            <th>Hora Salida</th>
            <th>Tiempo minutos</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><center><?php echo $row['id']; ?></center></td>
            <td><center><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></center></td>
            <td><center><?php echo $row['parqueadero_nombre']; ?></center></td>
            <td><center><?php echo $row['placa_vehiculo']; ?></center></td>
            <td><center><?php echo $row['fecha_entrada']; ?></center></td>
            <td><center><?php echo $row['hora_entrada']; ?></center></td>
            <td><center><?php echo $row['fecha_salida']; ?></center></td>
            <td><center><?php echo $row['hora_salida']; ?></center></td>
            <td><center><?php echo $row['tiempo_estancia']; ?></center></td>
            <td><center><?php echo $row['valor']; ?></center></td>
            <td><center><?php echo $row['estado']; ?></center></td>
            <td>
                <a href="cambiar_estado_reserva.php?id=<?php echo $row['id']; ?>">Cambiar Estado</a> |
                <a href="eliminar_reserva.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

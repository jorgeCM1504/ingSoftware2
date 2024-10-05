<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener los parqueaderos disponibles
$sql = "SELECT * FROM parqueaderos WHERE disponibilidad = 1";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parqueadero_id = $_POST['parqueadero_id'];
    $placa_vehiculo = $_POST['placa_vehiculo'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $hora_entrada = $_POST['hora_entrada'];

    // Obtener el tipo de vehículo del usuario basado en el usuario_id
    $sql_tipo = "SELECT tipo_vehiculo FROM usuarios WHERE id = '$usuario_id'";
    $result_tipo = $conn->query($sql_tipo);

    if ($result_tipo->num_rows > 0) {
        $tipo_vehiculo = $result_tipo->fetch_assoc()['tipo_vehiculo'];
    } else {
        // Manejar el caso donde no se encuentra el tipo de vehículo
        echo "No se encontró el tipo de vehículo para el usuario.";
        exit();
    }

    // Insertar la reserva con el tipo de vehículo obtenido
    $sql_reserva = "INSERT INTO reservas (usuario_id, parqueadero_id, placa_vehiculo, tipo_vehiculo, fecha_entrada, hora_entrada, estado) 
                    VALUES ('$usuario_id', '$parqueadero_id', '$placa_vehiculo', '$tipo_vehiculo', '$fecha_entrada', '$hora_entrada', 'Reservado')";

    if ($conn->query($sql_reserva) === TRUE) {
        echo "Reserva creada correctamente.";
    } else {
        echo "Error al crear la reserva: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Parqueadero</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Reservar Parqueadero</h2>

    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="historial_reservas.php">Historial</a></li>
    </ul>
    

    <form action="reservar.php" method="post">
        <label for="parqueadero_id">Selecciona un Parqueadero:</label>
        <select id="parqueadero_id" name="parqueadero_id" required>
            <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['nombre']; ?> - <?php echo $row['direccion']; ?>
            </option>
            <?php endwhile; ?>
        </select><br>

        <label for="placa_vehiculo">Placa del Vehículo:</label>
        <input type="text" id="placa_vehiculo" name="placa_vehiculo" required><br>

        <label for="fecha_entrada">Fecha de Entrada:</label>
        <input type="date" id="fecha_entrada" name="fecha_entrada" required><br>

        <label for="hora_entrada">Hora de Entrada:</label>
        <input type="time" id="hora_entrada" name="hora_entrada" required><br>

        <button type="submit">Reservar</button><br>

        <a href="logout.php">Cerrar Sesión</a>

    </form>
</body>
</html>

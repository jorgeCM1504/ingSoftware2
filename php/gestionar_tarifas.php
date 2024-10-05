<?php
session_start();
include 'conexion.php';


// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../html/login.html");
    exit();
}

// Obtener todas las tarifas
$sql = "SELECT * FROM tarifas";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$tipo_vehiculo = $_POST['tipo_vehiculo'];
    $tiempo_estancia = $_POST['tiempo_estancia'];
    $tarifa = $_POST['tarifa'];
    /*$horario = $_POST['horario'];*/
	
    // Inserción de la tarifa
    $sql = "INSERT INTO tarifas (tipo_vehiculo, tiempo_estancia, tarifa) 
            VALUES ('$tipo_vehiculo', '$tiempo_estancia', '$tarifa')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la misma página
        header("Location: gestionar_tarifas.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Tarifas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Gestionar Tarifas</h2>
    
    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
           
    </ul>


    <form action="gestionar_tarifas.php" method="post">
        <label for="tipo_vehiculo">Tipo de Vehículo:</label>
        <select id="tipo_vehiculo" name="tipo_vehiculo" required>
            <option value="Auto">Auto</option>
            <option value="Moto">Moto</option>
            <option value="Camion">Camión</option>
            <option value="Otro">Otro</option>
        </select><br>

        <label for="tiempo_estancia">Tiempo de Estancia (horas):</label>
        <input type="number" id="tiempo_estancia" name="tiempo_estancia" required><br>

        <label for="tarifa">Tarifa:</label>
        <input type="text" id="tarifa" name="tarifa" required><br>

        <!--<label for="horario">Horario:</label>
        <input type="text" id="horario" name="horario" required><br>-->

        <button type="submit">Guardar Tarifa</button>
    </form>

    <h3>Tarifas Existentes</h3>
    <table>
        <tr>
            <th>Tipo de Vehículo</th>
            <th>Tiempo de Estancia</th>
            <th>Tarifa</th>
            
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['tipo_vehiculo']; ?></td>
            <td><?php echo $row['tiempo_estancia']; ?></td>
            <td><?php echo $row['tarifa']; ?></td>
            
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

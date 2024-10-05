<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../html/login.html");
    exit();
}

// Obtener todos los parqueaderos
$sql = "SELECT * FROM parqueaderos";
$result = $conn->query($sql);

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $disponibilidad = $_POST['disponibilidad'] ? 1 : 0;

    $sql = "INSERT INTO parqueaderos (nombre, direccion, disponibilidad) 
            VALUES ('$nombre', '$direccion', '$disponibilidad')";

    if ($conn->query($sql) === TRUE) {
        echo "Parqueadero creado correctamente.";
    } else {
        echo "Error al crear el parqueadero: " . $conn->error;
    }
}*/



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $disponibilidad = $_POST['disponibilidad'] ? 1 : 0;
	
    // Inserción del parqueadero
    $sql = "INSERT INTO parqueaderos (nombre, direccion, disponibilidad) 
            VALUES ('$nombre', '$direccion', '$disponibilidad')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la misma página
        header("Location: gestionar_parqueaderos.php");
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
    <title>Gestionar Parqueaderos</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Gestionar Parqueaderos</h2>
    <form action="gestionar_parqueaderos.php" method="post">
        <label for="nombre">Nombre del Parqueadero:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>

        <label for="disponibilidad">Disponible:</label>
        <input type="checkbox" id="disponibilidad" name="disponibilidad"><br>

        <button type="submit">Guardar Parqueadero</button>
    </form>

    <h3>Parqueaderos Existentes</h3>
    
    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
           
    </ul>


    <table>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Disponible</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['direccion']; ?></td>
            <td><?php echo $row['disponibilidad'] ? 'Sí' : 'No'; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

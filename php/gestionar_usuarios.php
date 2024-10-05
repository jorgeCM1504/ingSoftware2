<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../html/login.html");
    exit();
}

// Obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Gestionar Usuarios</h2>
    <ul>
            <li><a href="dashboard.php">Inicio</a></li>
           
    </ul>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Correo</th>
            <th>Tipo de Vehículo</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['apellido']; ?></td>
            <td><?php echo $row['cedula']; ?></td>
            <td><?php echo $row['correo']; ?></td>
            <td><?php echo $row['tipo_vehiculo']; ?></td>
            <td>
                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>">Editar</a> |
                <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

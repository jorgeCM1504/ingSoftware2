<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location:../html/login.html");
    exit();
}

// Obtener información del usuario
$usuario_id = $_SESSION['usuario_id'];
$es_admin = $_SESSION['es_admin'];

$sql = "SELECT * FROM usuarios WHERE id='$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Bienvenido, <?php echo $usuario['nombre']; ?>!</h2>

    <?php if ($es_admin): ?>
        <h3>Panel de Administrador</h3>
        <ul>
            <li><a href="gestionar_usuarios.php">Gestionar Usuarios</a></li>
            <li><a href="gestionar_reservas.php">Gestionar Reservas</a></li>
            <li><a href="gestionar_tarifas.php">Gestionar Tarifas</a></li>
			<li><a href="gestionar_parqueaderos.php">Gestionar Parqueaderos</a></li>
			<li><a href="mapa_parqueaderos.php">Mapa Parqueaderos</a></li>
        </ul>
    <?php else: ?>
        <h3>Panel de Usuario</h3>
        <ul>
            <li><a href="reservar.php">Reservar Parqueadero</a></li>
            <li><a href="historial_reservas.php">Historial de Reservas</a></li>
        </ul>
    <?php endif; ?>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

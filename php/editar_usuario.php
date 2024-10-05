<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../html/login.html");
    exit();
}

// Obtener el ID del usuario a editar
$usuario_id = $_GET['id'];

// Obtener información del usuario
$sql = "SELECT * FROM usuarios WHERE id='$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $tipo_vehiculo = $_POST['tipo_vehiculo'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', cedula='$cedula', correo='$correo', tipo_vehiculo='$tipo_vehiculo', direccion='$direccion' WHERE id='$usuario_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar usuario: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
</head>
<body>
    <h2>Editar Usuario</h2>
    <form action="editar_usuario.php?id=<?php echo $usuario_id; ?>" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>" required><br>

        <label for="cedula">Número de Cédula:</label>
        <input type="text" id="cedula" name="cedula" value="<?php echo $usuario['cedula']; ?>" required><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required><br>

        <label for="tipo_vehiculo">Tipo de Vehículo:</label>
        <select id="tipo_vehiculo" name="tipo_vehiculo" required>
            <option value="Auto" <?php if ($usuario['tipo_vehiculo'] == 'Auto') echo 'selected'; ?>>Auto</option>
            <option value="Moto" <?php if ($usuario['tipo_vehiculo'] == 'Moto') echo 'selected'; ?>>Moto</option>
            <option value="Camion" <?php if ($usuario['tipo_vehiculo'] == 'Camion') echo 'selected'; ?>>Camión</option>
            <option value="Otro" <?php if ($usuario['tipo_vehiculo'] == 'Otro') echo 'selected'; ?>>Otro</option>
        </select><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo $usuario['direccion']; ?>"><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>

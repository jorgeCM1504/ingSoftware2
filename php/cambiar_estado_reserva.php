<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $reserva_id = intval($_POST['id']);
    $nuevo_estado = $conn->real_escape_string($_POST['estado']);
    $fecha_salida = $conn->real_escape_string($_POST['fecha_salida']);
    $hora_salida = $conn->real_escape_string($_POST['hora_salida']);

    // Obtener la fecha y hora de entrada y el tipo de vehículo
    $sql = "SELECT fecha_entrada, hora_entrada, tipo_vehiculo FROM reservas 
            WHERE id = '$reserva_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "Reserva no encontrada.";
        exit();
    }

    $reserva = $result->fetch_assoc();

    $fecha_entrada = $reserva['fecha_entrada'];
    $hora_entrada = $reserva['hora_entrada'];
    $tipo_vehiculo = $reserva['tipo_vehiculo'];

    // Crear objetos DateTime para calcular el tiempo de estancia
    $datetime_entrada = new DateTime("$fecha_entrada $hora_entrada");
    $datetime_salida = new DateTime("$fecha_salida $hora_salida");

    // Calcular el intervalo en minutos
    $interval = $datetime_entrada->diff($datetime_salida);
    $tiempo_estancia = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

    if ($tiempo_estancia <= 0) {
        echo "La fecha y hora de salida deben ser posteriores a la fecha y hora de entrada.";
        exit();
    }

    // Asignar valor en base al estado de la reserva
    if ($nuevo_estado == "Cancelado") {
        // Si el estado es "Cancelado", el valor es 0
        $valor = 0;
    } else {
        // Obtener la tarifa base para el tipo de vehículo (para estancias <= 60 minutos)
        $sql_tarifa_base = "SELECT tarifa FROM tarifas 
                            WHERE tipo_vehiculo = '$tipo_vehiculo' 
                            AND tiempo_estancia <= 60 
                            ORDER BY tiempo_estancia DESC LIMIT 1";
        $result_tarifa_base = $conn->query($sql_tarifa_base);

        if ($result_tarifa_base->num_rows > 0) {
            $tarifa_base = floatval($result_tarifa_base->fetch_assoc()['tarifa']);
        } else {
            // Manejar el caso donde no hay tarifa base
            echo "No se encontró la tarifa base para el tipo de vehículo.";
            exit();
        }

        if ($tiempo_estancia <= 60) {
            // Asignar tarifa base
            $valor = $tarifa_base;
        } else {
            // Calcular el número de horas, redondeando hacia arriba
            $horas = ceil($tiempo_estancia / 60);

            // Obtener la tarifa por hora para el tipo de vehículo
            $sql_tarifa_hora = "SELECT tarifa FROM tarifas 
                                WHERE tipo_vehiculo = '$tipo_vehiculo' 
                                AND tiempo_estancia = 60 
                                LIMIT 1";
            $result_tarifa_hora = $conn->query($sql_tarifa_hora);

            if ($result_tarifa_hora->num_rows > 0) {
                $tarifa_hora = floatval($result_tarifa_hora->fetch_assoc()['tarifa']);
            } else {
                // Si no hay tarifa por hora específica, usar la tarifa base
                $tarifa_hora = $tarifa_base;
            }

            // Calcular el valor total
            $valor = $horas * $tarifa_hora;
        }
    }

    // Actualizar la reserva con los nuevos datos
    $sql_update = "UPDATE reservas SET 
                    estado = '$nuevo_estado', 
                    fecha_salida = '$fecha_salida', 
                    hora_salida = '$hora_salida', 
                    tiempo_estancia = '$tiempo_estancia', 
                    valor = '$valor' 
                WHERE id = '$reserva_id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Estado de la reserva actualizado correctamente.";
    } else {
        echo "Error al actualizar el estado: " . $conn->error;
    }

    $conn->close();
    header("Location: gestionar_reservas.php");
    exit();
} else {
    // Mostrar formulario para seleccionar estado, fecha y hora de salida
    $reserva_id = intval($_GET['id']);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cambiar Estado de Reserva</title>
        <link rel="stylesheet" href="../css/estilos.css">
        <link rel="icon" href="../img/parqueadero.ico" type="image/x-icon">
    </head>
    <body>
        <h2>Cambiar Estado de Reserva</h2>
        <form action="cambiar_estado_reserva.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $reserva_id; ?>">
            
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="Pendiente">Pendiente</option>
                <option value="Completado">Completado</option>
                <option value="Cancelado">Cancelado</option>
            </select>

            <br><br>

            <label for="fecha_salida">Fecha de Salida:</label>
            <input type="date" name="fecha_salida" id="fecha_salida" required>

            <label for="hora_salida">Hora de Salida:</label>
            <input type="time" name="hora_salida" id="hora_salida" required>

            <br><br>

            <button type="submit">Actualizar Reserva</button>
        </form>
    </body>
    </html>
    <?php
}
?>

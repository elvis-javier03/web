<?php
$conexion = new mysqli("localhost", "root", "", "lista_deseos");

if (isset($_GET['reservar'])) {
    $id = (int) $_GET['reservar'];
    $conexion->query("UPDATE regalos SET reservado = 1 WHERE id = $id");
    header("Location: index.php");
    exit();
}

$disponibles = $conexion->query("SELECT * FROM regalos WHERE reservado = 0");
$reservados = $conexion->query("SELECT * FROM regalos WHERE reservado = 1");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Deseos - Cumpleaños de 15</title>
    <link rel="stylesheet" href="estilo.css">
    <script>
        function confirmarReserva(id, nombre) {
            if (confirm("¿Estás seguro de que quieres reservar '" + nombre + "'?")) {
                window.location.href = "?reservar=" + id;
            }
        }
    </script>
</head>
<body>
    <div class="contenedor">
        <h1>🎉 Lista de Deseos de la Cumpleañera 🎀</h1>
        <div class="mensaje">
    <img src="img/mensaje.jpg" alt="Mensaje de la cumpleañera" class="imagen-mensaje">
</div>


        <h2>🎁 Regalos Disponibles</h2>
        <div class="regalos">
            <?php while ($r = $disponibles->fetch_assoc()): ?>
                <div class="tarjeta">
                    <h3><?= htmlspecialchars($r['nombre']) ?></h3>
                    <p><?= htmlspecialchars($r['descripcion']) ?></p>
                    <button onclick="confirmarReserva(<?= $r['id'] ?>, '<?= addslashes($r['nombre']) ?>')">Reservar</button>
                </div>
            <?php endwhile; ?>
        </div>

        <h2 class="separador">✅ Regalos Reservados</h2>
        <div class="regalos reservados">
            <?php while ($r = $reservados->fetch_assoc()): ?>
                <div class="tarjeta reservado">
                    <h3><?= htmlspecialchars($r['nombre']) ?></h3>
                    <p><?= htmlspecialchars($r['descripcion']) ?></p>
                    <span class="etiqueta">Reservado</span>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

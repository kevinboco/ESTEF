<?php
require 'conexion.php';
session_start();

// Buscar accesos pendientes
$sql = "SELECT accesos.id, usuarios.usuario, accesos.codigo, accesos.modo, accesos.fecha 
        FROM accesos 
        JOIN usuarios ON accesos.usuario_id = usuarios.id 
        WHERE accesos.estado = 'pendiente' 
        ORDER BY accesos.fecha DESC";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Validar Accesos - Vigilante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Validar Accesos Pendientes</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Código</th>
                    <th>Modo</th>
                    <th>Fecha</th>
                    <th>Subir Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $fila['usuario'] ?></td>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= ucfirst($fila['modo']) ?></td>
                        <td><?= $fila['fecha'] ?></td>
                        <td>
                            <form method="POST" action="procesar_placa.php" enctype="multipart/form-data">
                                <input type="hidden" name="acceso_id" value="<?= $fila['id'] ?>">
                                <input type="file" name="imagen" required>
                                <button type="submit" class="btn btn-sm btn-primary mt-1">Validar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay accesos pendientes.</div>
    <?php endif ?>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar salida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Salida de la Universidad</h4>
        </div>
        <div class="card-body">
            <form action="salida_estudiante.php" method="post">
                <div class="mb-3">
                    <label for="codigo" class="form-label">Ingresa tu código de acceso</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" required pattern="[0-9]+" title="Solo números">
                </div>
                <button type="submit" class="btn btn-danger">Registrar salida</button>
            </form>
            <hr>
            <a href="vista_estudiante.php" class="btn btn-secondary">Volver al panel</a>
        </div>
    </div>
</div>
</body>
</html>

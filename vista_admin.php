<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Panel del Administrador</h4>
        </div>
        <div class="card-body">
            <p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>

            <hr>

            <h5>Validar placa con OCR</h5>
            <form action="subir_ocrspace.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="imagen_placa" class="form-label">Sube la foto de la placa:</label>
                    <input type="file" name="imagen" id="imagen_placa" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Validar Placa</button>
            </form>

            <hr>

            <h5>Solicitudes Pendientes de Validación</h5>
            <a href="admin_validar_acceso.php" class="btn btn-warning">Ver solicitudes pendientes</a>

            <hr>

            <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

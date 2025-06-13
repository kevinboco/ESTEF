<?php
session_start();
require_once 'conexion.php';

// Proteger acceso
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}

// Obtener datos del usuario
$id = $_SESSION['usuario_id'];
$sql = "SELECT codigo_acceso FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

$codigo = $usuario['codigo_acceso'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h4>
        </div>
        <div class="card-body">

            <?php if ($codigo): ?>
                <p class="alert alert-info"><strong>Tu código actual es:</strong> <?php echo htmlspecialchars($codigo); ?></p>

                <form method="post" action="modificar_codigo.php">
                    <div class="mb-3">
                        <label class="form-label">Modificar código (solo números):</label>
                        <input type="number" name="nuevo_codigo" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Guardar nuevo código</button>
                </form>
            <?php else: ?>
                <form method="post" action="generar_codigo.php">
                    <button type="submit" class="btn btn-success">Generar Código Personal</button>
                </form>
            <?php endif; ?>

            <hr>

            <h5>Simular Entrada / Salida</h5>
            <div class="d-flex gap-2">
                <form action="vista_entrada.php" method="get">
                    <button class="btn btn-outline-primary">Entrar a la Universidad</button>
                </form>
                <form action="vista_salida.php" method="get">
                    <button class="btn btn-outline-danger">Salir de la Universidad</button>
                </form>
            </div>

            <hr>
            <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

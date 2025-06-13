<?php
require 'conexion.php';
session_start();

if (!isset($_POST['codigo'], $_POST['tipo'])) {
    header("Location: vista_entrada.php");
    exit();
}

$codigo = $_POST['codigo'];
$tipo = $_POST['tipo']; // 'entrada' o 'salida'

// Buscar usuario por código
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE codigo_acceso = ?");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $mensaje = "❌ Código inválido.";
} else {
    $usuario = $result->fetch_assoc();
    $usuario_id = $usuario['id'];

    // Insertar registro en la tabla accesos
    $stmt = $conexion->prepare("INSERT INTO accesos (usuario_id, codigo, modo, estado) VALUES (?, ?, ?, 'pendiente')");
    $stmt->bind_param("iss", $usuario_id, $codigo, $tipo);
    $stmt->execute();

    $mensaje = "✅ Código registrado. El vigilante debe subir la imagen de la placa.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="alert alert-info">
        <?= $mensaje ?>
    </div>
    <a href="vista_estudiante.php" class="btn btn-secondary">Volver</a>
</body>
</html>

<?php
require 'conexion.php';
session_start();

if (!isset($_POST['codigo'])) {
    die("Código no recibido.");
}

$codigo = $_POST['codigo'];
$tipo = 'salida';

// Buscar ID del usuario por su código
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE codigo_acceso = ?");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Código inválido.");
}

$usuario = $result->fetch_assoc();
$usuario_id = $usuario['id'];

// Insertar registro de salida
$stmt = $conexion->prepare("INSERT INTO accesos (usuario_id, codigo, modo, estado) VALUES (?, ?, ?, 'pendiente')");
$stmt->bind_param("iss", $usuario_id, $codigo, $tipo);
$stmt->execute();

echo "<!DOCTYPE html>
<html><head><meta charset='UTF-8'><title>Salida registrada</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head><body class='container mt-5'>
<div class='alert alert-success'>✅ Salida registrada correctamente. El vigilante debe validar la placa.</div>
<a href='vista_estudiante.php' class='btn btn-secondary'>Volver al panel</a>
</body></html>";

<?php
session_start();
require_once 'conexion.php';

if ($_SESSION['rol'] !== 'estudiante') {
    header("Location: login.php");
    exit;
}

$nuevo_codigo = $_POST['nuevo_codigo'];

// Validar que solo contenga números
if (!ctype_digit($nuevo_codigo)) {
    echo "<p>El código debe ser solo numérico. <a href='vista_estudiante.php'>Volver</a></p>";
    exit;
}

$sql = "UPDATE usuarios SET codigo_acceso = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $nuevo_codigo, $_SESSION['usuario_id']);
$stmt->execute();

header("Location: vista_estudiante.php");
?>

<?php
require_once 'conexion.php';

$usuario = $_POST['usuario'];
$clave = hash('sha256', $_POST['clave']);
$codigo = null; // Código aún no generado

// Verificar si ya existe
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p>El usuario ya existe. <a href='login.php'>Volver</a></p>";
    exit;
}

// Insertar nuevo estudiante sin código aún
$sql = "INSERT INTO usuarios (usuario, clave, rol, codigo_acceso) VALUES (?, ?, 'estudiante', ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $usuario, $clave, $codigo);

if ($stmt->execute()) {
    header("Location: login.php?registrado=1");
    exit;
} else {
    echo "Error al registrar.";
}
?>


<?php
session_start();
require_once 'conexion.php';

$usuario = $_POST['usuario'];
$clave = hash('sha256', $_POST['clave']);

$sql = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $clave);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $usuario = $resultado->fetch_assoc();
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario'] = $usuario['usuario'];
    $_SESSION['rol'] = $usuario['rol'];

    switch ($usuario['rol']) {
        case 'admin':
            header("Location: vista_admin.php");
            break;
        case 'estudiante':
            header("Location: vista_estudiante.php");
            break;
        case 'vigilante':
            header("Location: vista_vigilante.php");
            break;
    }
} else {
    echo "<p>Usuario o clave incorrectos. <a href='login.php'>Volver</a></p>";
}
?>

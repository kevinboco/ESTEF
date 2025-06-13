<?php
$conexion = new mysqli("localhost", "root", "", "control_acceso");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

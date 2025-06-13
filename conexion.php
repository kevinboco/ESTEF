<?php
$conexion = new mysqli("mysql.hostinger.com", "u648222299_keboco3", "Bucaramanga3011", "u648222299_zonanorte");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

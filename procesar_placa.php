<?php
require 'conexion.php';
$TOKEN = "833227e66c4c316007d4c19e4874faa1fd51efcf";

if (!isset($_POST['acceso_id']) || !isset($_FILES['imagen'])) {
    die("Faltan datos.");
}

$acceso_id = $_POST['acceso_id'];
$imagen = $_FILES['imagen'];

// Guardar temporalmente la imagen
$nombre_temporal = $imagen['tmp_name'];

// Enviar a Plate Recognizer
$url = "https://api.platerecognizer.com/v1/plate-reader/";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Token $TOKEN"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'upload' => new CURLFile($nombre_temporal)
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$placa_detectada = isset($data['results'][0]['plate']) ? strtoupper($data['results'][0]['plate']) : null;

if (!$placa_detectada) {
    // No se detectó placa
    $stmt = $conexion->prepare("UPDATE accesos SET estado = 'denegado' WHERE id = ?");
    $stmt->bind_param("i", $acceso_id);
    $stmt->execute();

    $mensaje = "❌ No se detectó ninguna placa. Acceso denegado.";
} else {
    // Consultar información del acceso actual
    $stmt = $conexion->prepare("SELECT usuario_id, modo FROM accesos WHERE id = ?");
    $stmt->bind_param("i", $acceso_id);
    $stmt->execute();
    $acceso = $stmt->get_result()->fetch_assoc();

    $usuario_id = $acceso['usuario_id'];
    $modo = $acceso['modo'];

    if ($modo === 'salida') {
        // Buscar última entrada aprobada de este usuario
        $stmt = $conexion->prepare("SELECT placa_detectada FROM accesos WHERE usuario_id = ? AND modo = 'entrada' AND estado = 'aprobado' ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            // No hay entrada previa aprobada
            $estado = 'denegado';
            $mensaje = "❌ No hay entrada previa aprobada. Acceso denegado.";
        } else {
            $entrada = $resultado->fetch_assoc();
            $placa_entrada = strtoupper($entrada['placa_detectada']);

            if ($placa_detectada === $placa_entrada) {
                $estado = 'aprobado';
                $mensaje = "✅ Placa detectada: $placa_detectada. Salida aprobada.";
            } else {
                $estado = 'denegado';
                $mensaje = "❌ Placa detectada: $placa_detectada. No coincide con la entrada ($placa_entrada).";
            }
        }
    } else {
        // Es una entrada, simplemente se aprueba
        $estado = 'aprobado';
        $mensaje = "✅ Placa detectada: $placa_detectada. Entrada aprobada.";
    }

    // Actualizar acceso
    $stmt = $conexion->prepare("UPDATE accesos SET placa_detectada = ?, estado = ? WHERE id = ?");
    $stmt->bind_param("ssi", $placa_detectada, $estado, $acceso_id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="alert alert-info"><?= $mensaje ?></div>
    <a href="admin_validar_acceso.php" class="btn btn-secondary">Volver</a>
</body>
</html>

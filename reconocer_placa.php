<?php
if (isset($_FILES['imagen'])) {
    $token = '833227e66c4c316007d4c19e4874faa1fd51efcf'; // Tu token de Plate Recognizer

    $filename = $_FILES['imagen']['tmp_name'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.platerecognizer.com/v1/plate-reader/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = [
        'Authorization: Token ' . $token
    ];

    $postFields = [
        'upload' => curl_file_create($filename)
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    $resultado = json_decode($response, true);

    if (isset($resultado['results'][0]['plate'])) {
        $placa = strtoupper($resultado['results'][0]['plate']);
        echo "<h2>✅ Placa detectada:</h2><p style='font-size:24px;'>$placa</p>";
    } else {
        echo "<h2>❌ No se pudo detectar la placa.</h2><pre>" . htmlspecialchars($response) . "</pre>";
    }
} else {
    echo "No se subió ninguna imagen.";
}
?>


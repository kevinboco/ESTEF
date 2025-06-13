<!DOCTYPE html>
<html>
<head>
    <title>Reconocimiento de Placas</title>
</head>
<body>
    <h2>Sube una imagen de una placa</h2>
    <form action="reconocer_placa.php" method="post" enctype="multipart/form-data">
        Imagen: <input type="file" name="imagen" accept="image/*" required><br><br>
        <input type="submit" value="Detectar Placa">
    </form>
</body>
</html>

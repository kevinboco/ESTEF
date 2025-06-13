<!DOCTYPE html>
<html>
<head>
    <title>Entrar a la Universidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Entrar a la Universidad</h3>
    <form method="POST" action="entrada_estudiante.php">
        <div class="mb-3">
            <label for="codigo" class="form-label">Ingresa tu código de acceso:</label>
            <input type="number" name="codigo" id="codigo" class="form-control" required>
        </div>
        <input type="hidden" name="tipo" value="entrada">
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</body>
</html>

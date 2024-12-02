<?php
session_start();
$error = $_SESSION['error'] ?? 'Ocurrió un error desconocido.';
unset($_SESSION['error']); // Limpiamos el mensaje después de mostrarlo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h1>Error</h1>
    <p><?= htmlspecialchars($error) ?></p>
    <a href="./index.html">Volver al inicio</a>
</body>
</html>

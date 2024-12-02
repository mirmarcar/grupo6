<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ./error.php?error=unauthorized');
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($user['nom']) ?>!</h1>
    <p>Tu correo es: <?= htmlspecialchars($user['email']) ?></p>
    <a href="/public/logout.php">Cerrar sesión</a>
</body>
</html>

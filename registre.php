<?php
require_once __DIR__ . '/../DL/databaseDL.php';
require_once __DIR__ . '/../helpers/validation.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar y validar datos del formulario
    $nom = sanitizeInput($_POST['nom'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $passwd = sanitizeInput($_POST['passwd'] ?? '');

    if (empty($nom) || empty($email) || empty($passwd)) {
        header('Location: /../error.php?error=missing_fields');
        exit;
    }

    if (!isValidEmail($email)) {
        header('Location: /../error.php?error=invalid_email');
        exit;
    }

    if (!isValidPassword($passwd)) {
        header('Location: /../error.php?error=weak_password');
        exit;
    }

    // Cifrar contraseña
    $hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);

    // Guardar usuario en la base de datos usando MySQLi
    try {
        // Crear la conexión con MySQLi
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Verificar la conexión
        if ($mysqli->connect_error) {
            die('Error de conexión: ' . $mysqli->connect_error);
        }

        // Prevenir inyecciones SQL con consultas preparadas
        $query = "INSERT INTO usuari (nom, email, passwd) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sss', $nom, $email, $hashedPasswd); // 'sss' significa que los tres parámetros son cadenas

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Crear sesión para el usuario registrado
            $_SESSION['user'] = ['nom' => $nom, 'email' => $email];
            header('Location: /../dashboard.php');
        } else {
            header('Location: /../error.php?error=user_exists');
        }

        // Cerrar la conexión y el statement
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        // Si hay un error al intentar guardar el usuario
        header('Location: /../error.php?error=database_error');
    }
}
?>

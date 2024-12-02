<?php
require_once __DIR__ . '/../DL/databaseDL.php';
require_once __DIR__ . '/../helpers/validation.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $passwd = sanitizeInput($_POST['passwd'] ?? '');

    if (empty($email) || empty($passwd)) {
        header('Location: /../error.php?error=missing_fields');
        exit;
    }

    if (!isValidEmail($email)) {
        header('Location: /../error.php?error=invalid_email');
        exit;
    }

    // Verificar usuario y contraseña con MySQLi
    try {
        // Crear conexión con MySQLi
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Verificar la conexión
        if ($db->connect_error) {
            die("Error de conexión: " . $db->connect_error);
        }

        // Preparar la consulta para evitar inyecciones SQL
        $query = "SELECT * FROM usuari WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $email); // 's' para string

        $stmt->execute();
        $result = $stmt->get_result(); // Obtener el resultado de la consulta

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($passwd, $row['passwd'])) {
                // Crear sesión para el usuario autenticado
                $_SESSION['user'] = ['nom' => $row['nom'], 'email' => $row['email']];
                header('Location: /../dashboard.php');
                exit;
            } else {
                header('Location: /../error.php?error=invalid_credentials');
                exit;
            }
        } else {
            header('Location: /../error.php?error=invalid_credentials');
            exit;
        }
    } catch (Exception $e) {
        // Manejar cualquier error de base de datos
        header('Location: /../error.php?error=database_error');
    }
}
?>

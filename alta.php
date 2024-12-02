<?php
require_once './BL/usuariBL.php';
require_once './helpers/validation.php'; // Funciones de validación

session_start();

if ($_POST) {
    // Validamos las entradas
    $nom = validaTexto($_POST['nom'] ?? '');
    $email = validaEmail($_POST['email'] ?? '');
    $passwd = $_POST['passwd'] ?? '';

    // Comprobamos que todos los campos sean válidos
    if (empty($nom) || empty($email) || empty($passwd) || !validaPassword($passwd)) {
        $_SESSION['error'] = "Datos inválidos o incompletos.";
        header('Location: ./error.php');
        exit;
    }

    // Creamos la instancia de lógica de negocio
    $usuari = new usuarisBL();

    // Intentamos registrar al usuario
    $resultat = $usuari->altaUsuari($nom, $email, $passwd);

    if ($resultat) {
        // Redirigimos al login si el registro fue exitoso
        header('Location: ./index.php');
    } else {
        // Redirigimos a la página de error si el registro falla
        $_SESSION['error'] = "El registro falló. Es posible que el email ya esté registrado.";
        header('Location: ./error.php');
    }
}
?>

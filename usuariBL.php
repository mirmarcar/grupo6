<?php
require_once '/../DL/databaseDL.php';

class UsuarisBL {
    private $db;

    public function __construct() {
        $this->db = new DatabaseDL(); // Usando la clase de conexión MySQLi
    }

    public function altaUsuari($nom, $email, $passwd) {
        // Comprobamos si el email ya está registrado
        $sql = "SELECT * FROM usuari WHERE email = ?";
        $stmt = $this->db->query($sql, [$email]);

        // Verificamos si el email ya existe
        if ($stmt->num_rows > 0) {
            return false; // El email ya existe
        }

        // Registramos al nuevo usuario
        $hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuari (nom, email, passwd) VALUES (?, ?, ?)";
        $this->db->query($sql, [$nom, $email, $hashedPasswd]);

        return true;
    }
}
?>

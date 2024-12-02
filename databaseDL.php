<?php
class DatabaseDL {
    private $mysqli;

    public function __construct() {
        $host = 'mysql-mireia.alwaysdata.net'; // Cambia la dirección de host si es necesario
        $user = 'mireia';
        $password = 'marmirecarles@123';
        $dbname = 'mireia_notes'; // Nombre de tu base de datos

        // Crear la conexión con MySQLi
        $this->mysqli = new mysqli($host, $user, $password, $dbname);

        // Verificar la conexión
        if ($this->mysqli->connect_error) {
            die('Error en la conexión: ' . $this->mysqli->connect_error);
        }
    }

    // Método para ejecutar una consulta
    public function query($sql, $params = []) {
        $stmt = $this->mysqli->prepare($sql);

        if ($params) {
            // Si hay parámetros, los vinculamos
            $types = str_repeat('s', count($params)); // Asumimos que todos los parámetros son strings
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }

    // Método para cerrar la conexión
    public function close() {
        $this->mysqli->close();
    }
}
?>

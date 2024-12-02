<?php
// Configuración de la base de datos
define('DB_HOST', 'mysql-mireia.alwaysdata.net');
define('DB_USER', 'mireia');
define('DB_PASS', 'marmirecarles@123');
define('DB_NAME', 'mireia_notes');

// Conexión a la base de datos con MySQLi
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar si la conexión fue exitosa
if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

echo "Conexión exitosa a la base de datos.";
?>

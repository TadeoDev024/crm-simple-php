<?php
// conexion.php

// Configuración de credenciales
// NOTA: En producción, estas variables deberían venir de un archivo .env fuera del root público
$host = 'localhost';
$db   = 'crm_simple';
$user = 'root';      // Cambia esto por tu usuario de MySQL
$pass = '';          // Cambia esto por tu contraseña de MySQL
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones de configuración de PDO
$options = [
    // Lanza excepciones en caso de error (fundamental para debugging)
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Obtiene los resultados como arrays asociativos por defecto
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Desactiva la emulación de sentencias preparadas (mejor seguridad)
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Intento de conexión
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Si llegamos aquí, la conexión fue exitosa.
    // echo "¡Conexión exitosa!"; // Descomentar solo para probar
} catch (\PDOException $e) {
    // Si falla, capturamos el error
    // En producción, es mejor registrar esto en un log y no mostrar el error técnico al usuario
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
<?php
// config/database.php

function getDBConnection() {
    $host = 'localhost';
    $db   = 'crm_simple';
    $user = 'root';
    $pass = ''; // Cambia según tu configuración
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // En producción, loguear el error en un archivo, no mostrarlo al usuario
        die("Error de conexión a la Base de Datos."); 
    }
}
?>
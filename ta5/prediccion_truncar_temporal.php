<?php
// Credenciales de la base de datos
$host = 'localhost';
$dbname = 'ta';
$username = 'root';
$password = '';

try {
    // Conexión a la base de datos utilizando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para eliminar todos los registros de la tabla 'tmptension'
    $sql = "DELETE FROM tmptension";

    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta
    $stmt->execute();

    //echo "Todos los registros han sido eliminados correctamente.";
} catch (PDOException $e) {
    // Manejo de excepciones
    echo "Error al eliminar los registros: " . $e->getMessage();
}


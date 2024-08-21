<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'ta';
$username = 'root';
$password = '';

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta para eliminar todos los registros de la tabla prediccion
    $sql = "DELETE FROM prediccion";
    
    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Confirmación de la eliminación
    // echo "Todos los registros han sido eliminados de la tabla 'prediccion'.";
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$pdo = null;

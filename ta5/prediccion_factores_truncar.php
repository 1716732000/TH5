<?php
// Configuración de la conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=ta';
$username = 'root';
$password = '';

try {
    // Crear una nueva instancia de PDO
    $pdo = new PDO($dsn, $username, $password);

    // Configurar el modo de error de PDO para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Definir la consulta SQL para eliminar todos los registros de la tabla tmpfactores
    $sql = "DELETE FROM tmpfactores";

    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta
    $stmt->execute();

    // Confirmación de éxito
    // echo "Todos los registros de la tabla tmpfactores han sido eliminados.";

} catch (PDOException $e) {
    // Manejo de excepciones y errores
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos (opcional, ya que PDO lo hace automáticamente al final del script)
$pdo = null;


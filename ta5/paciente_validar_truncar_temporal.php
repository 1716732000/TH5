<?php
    // Configuración de la base de datos
    $host = 'localhost';
    $dbname = 'ta';
    $username = 'root';
    $password = '';

    try {
        // Conexión a la base de datos
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        
        // Configurar PDO para lanzar excepciones en caso de error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Preparar la consulta SQL para borrar el contenido de la tabla tmppaciente
        $sql = "DELETE FROM tmppaciente";
        
        // Ejecutar la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        //echo "Contenido de la tabla tmppaciente borrado exitosamente.";
        
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: paciente_validar_truncar_temporal" . $e->getMessage();
    }

    // Cerrar la conexión
    $pdo = null;

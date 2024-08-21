<?php
try {
    // Establecer la conexión a la base de datos usando PDO
    $pdo = new PDO('mysql:host=localhost;dbname=ta', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los valores de las variables usando $_REQUEST
    $dui        = strtoupper($_REQUEST['txtDui']);
    $nombre     = strtoupper($_REQUEST['txtNombre']);
    $apellido   = strtoupper($_REQUEST['txtApellido']);
    $sexo       = strtoupper($_REQUEST['txtSexo']);
    $nacimiento = strtoupper($_REQUEST['txtNacimiento']);

    // Preparar la consulta para buscar el DUI en la tabla paciente
    $stmt = $pdo->prepare('SELECT * FROM paciente WHERE dui = :dui');
    $stmt->bindParam(':dui', $dui, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si el DUI ya existe en la tabla
    if ($stmt->rowCount() > 0) {
        echo "Error: El DUI ya está registrado.";
    } else {
        // Si no existe, insertar el nuevo registro en la tabla paciente
        $insertStmt = $pdo->prepare('INSERT INTO paciente (dui, nombre, apellido, sexo, nacimiento) VALUES (:dui, :nombre, :apellido, :sexo, :nacimiento)');
        $insertStmt->bindParam(':dui', $dui, PDO::PARAM_STR);
        $insertStmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $insertStmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $insertStmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
        $insertStmt->bindParam(':nacimiento', $nacimiento, PDO::PARAM_STR);
        $insertStmt->execute();

        echo "Registro insertado exitosamente.";
    }

} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}

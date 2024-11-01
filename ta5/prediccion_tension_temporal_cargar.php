<?php
// Configuración de la conexión a la base de datos
$dsn = "mysql:host=localhost;dbname=ta;charset=utf8";
$username = "root";
$password = "";

try {
    // Crear una nueva instancia de PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta el único registro de la tabla tmppaciente
    $stmt = $pdo->query("SELECT dui FROM tmppaciente LIMIT 1");
    $dui = $stmt->fetchColumn();

    if ($dui) {
        // Buscar los últimos 10 registros en la tabla tension que coincidan con el valor de $dui
        $stmt = $pdo->prepare("
            SELECT dui, sistole, diastole, ingreso 
            FROM tension 
            WHERE dui = :dui 
            ORDER BY ingreso DESC 
            
        ");
        //LIMIT 10
        $stmt->bindParam(':dui', $dui);
        $stmt->execute();
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Copiar los últimos 10 registros a la tabla tmptension
        $insertStmt = $pdo->prepare("
            INSERT INTO tmptension (dui, sistole, diastole, ingreso) 
            VALUES (:dui, :sistole, :diastole, :ingreso)
        ");

        foreach ($registros as $registro) {
            $insertStmt->execute([
                ':dui' => $registro['dui'],
                ':sistole' => $registro['sistole'],
                ':diastole' => $registro['diastole'],
                ':ingreso' => $registro['ingreso']
            ]);
        }

        //echo "Los últimos 10 registros han sido copiados a la tabla tmptension.";
    } else {
        echo "No se encontró ningún registro en la tabla tmppaciente.";
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}

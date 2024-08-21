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

    // 1. Consultar la tabla tmppaciente para obtener el valor del campo dui
    $sql1 = "SELECT dui FROM tmppaciente LIMIT 1";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    // Si se obtiene un resultado, asignar el valor del campo dui a la variable $dui
    if ($result1) {
        $dui = $result1['dui'];

        // 2. Buscar en la tabla factores el registro con el mismo valor de dui
        $sql2 = "SELECT * FROM factores WHERE dui = :dui";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':dui', $dui, PDO::PARAM_STR);
        $stmt2->execute();
        $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        // Si encuentra el registro, insertarlo en la tabla tmpfactores
        if ($result2) {
            $sql3 = "INSERT INTO tmpfactores (dui, historia, obesidad, sedentarismo, alcoholismo, tabaquismo, diabetes, colesterol)
                     VALUES (:dui, :historia, :obesidad, :sedentarismo, :alcoholismo, :tabaquismo, :diabetes, :colesterol)";
            
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->bindParam(':dui', $result2['dui'], PDO::PARAM_STR);
            $stmt3->bindParam(':historia', $result2['historia'], PDO::PARAM_STR);
            $stmt3->bindParam(':obesidad', $result2['obesidad'], PDO::PARAM_STR);
            $stmt3->bindParam(':sedentarismo', $result2['sedentarismo'], PDO::PARAM_STR);
            $stmt3->bindParam(':alcoholismo', $result2['alcoholismo'], PDO::PARAM_STR);
            $stmt3->bindParam(':tabaquismo', $result2['tabaquismo'], PDO::PARAM_STR);
            $stmt3->bindParam(':diabetes', $result2['diabetes'], PDO::PARAM_STR);
            $stmt3->bindParam(':colesterol', $result2['colesterol'], PDO::PARAM_STR);

            $stmt3->execute();

            //echo "Registro copiado exitosamente a la tabla tmpfactores.";
        } else {
            echo "No se encontró un registro en la tabla factores con el dui especificado.";
        }
    } else {
        echo "No se encontró un registro en la tabla tmppaciente.";
    }

} catch (PDOException $e) {
    // Manejo de excepciones y errores
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos (opcional)
$pdo = null;

<!--
    CAPTURAR PACIENTE DE TABLA TEMPORAL
    CARGAR DATOS DE TABLA FACTORES 
-->
<?php
// Configuración de la conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=ta';
$username = 'root';
$password = '';

try {
    // Crear una nueva instancia de PDO
    $pdo = new PDO($dsn, $username, $password);
    // Establecer el modo de error a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para seleccionar el único registro de la tabla tmppaciente
    $stmt = $pdo->prepare("SELECT dui FROM tmppaciente LIMIT 1");
    $stmt->execute();

    // Obtener el valor del campo dui
    $dui = $stmt->fetchColumn();

    if ($dui) {
        // Consulta para seleccionar el registro en la tabla factores basado en el dui
        $stmt = $pdo->prepare("SELECT historia, obesidad, sedentarismo, alcoholismo, tabaquismo, diabetes, colesterol 
                               FROM factores WHERE dui = :dui");
        $stmt->bindParam(':dui', $dui, PDO::PARAM_STR);
        $stmt->execute();

        // Cargar los valores en variables PHP
        $factor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($factor) {
            $historia = $factor['historia'];
            $obesidad = $factor['obesidad'];
            $sedentarismo = $factor['sedentarismo'];
            $alcoholismo = $factor['alcoholismo'];
            $tabaquismo = $factor['tabaquismo'];
            $diabetes = $factor['diabetes'];
            $colesterol = $factor['colesterol'];

            // Aquí puedes usar las variables como necesites
        } else {
            echo "No se encontró ningún registro en la tabla factores para el DUI especificado.";
        }
    } else {
        echo "No se encontró ningún DUI en la tabla tmppaciente.";
    }

} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}


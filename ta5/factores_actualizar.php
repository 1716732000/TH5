<!-- ACTUALIZAR FACTORES DE RIESGO -->
<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "factores_cargar_paciente.php";
            include_once "css.php";
         ?>
    </head>
    <body class="body">
        <table width="1100px" class="tablaTemporal">
            <tr>
                <td align="center">
                    <b>ACTUALIZACION DE FACTORES DE RIESGO</b>
                </td>
            </tr>
        </table>
    </body>
</html>
 
<?php
// Conexión a la base de datos usando PDO
$dsn = 'mysql:host=localhost;dbname=ta;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Variables obtenidas desde $_REQUEST[]
    //$dui = $_REQUEST['dui'];
    $historia = $_REQUEST['txtHistoria'];
    $obesidad = $_REQUEST['txtObesidad'];
    $sedentarismo = $_REQUEST['txtSedentarismo'];
    $alcoholismo = $_REQUEST['txtAlcoholismo'];
    $tabaquismo = $_REQUEST['txtTabaquismo'];
    $diabetes = $_REQUEST['txtDiabetes'];
    $colesterol = $_REQUEST['txtColesterol'];

    // Preparar la consulta SQL para buscar el registro por DUI
    $sql = "SELECT COUNT(*) FROM factores WHERE dui = :dui";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':dui', $dui, PDO::PARAM_STR);
    $stmt->execute();

    // Si se encuentra el DUI en la tabla, se procede a actualizar
    if ($stmt->fetchColumn() > 0) {
        $updateSql = "UPDATE factores SET 
            historia = :historia,
            obesidad = :obesidad,
            sedentarismo = :sedentarismo,
            alcoholismo = :alcoholismo,
            tabaquismo = :tabaquismo,
            diabetes = :diabetes,
            colesterol = :colesterol
            WHERE dui = :dui";

        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindParam(':historia', $historia, PDO::PARAM_STR);
        $updateStmt->bindParam(':obesidad', $obesidad, PDO::PARAM_STR);
        $updateStmt->bindParam(':sedentarismo', $sedentarismo, PDO::PARAM_STR);
        $updateStmt->bindParam(':alcoholismo', $alcoholismo, PDO::PARAM_STR);
        $updateStmt->bindParam(':tabaquismo', $tabaquismo, PDO::PARAM_STR);
        $updateStmt->bindParam(':diabetes', $diabetes, PDO::PARAM_STR);
        $updateStmt->bindParam(':colesterol', $colesterol, PDO::PARAM_STR);
        $updateStmt->bindParam(':dui', $dui, PDO::PARAM_STR);

        $updateStmt->execute();
        
        echo "<br>";
        echo "<table width='1100px' class='tablaTemporal'>
            <tr>
                <td align='center'>
                    <b>DATOS ACTUALIZADOS CORRECTAMENTE</b>
                </td>
            </tr>
        </table>";
        //echo "Datos actualizados correctamente.";
    } else {
        echo "El DUI no fue encontrado en la base de datos.";
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>

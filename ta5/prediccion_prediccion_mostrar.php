<?php
include_once "css.php";
// Configuración de la base de datos
$host = 'localhost'; 
$dbname = 'ta'; 
$user = 'root'; 
$pass = ''; 

try {
    // Crear una nueva instancia de PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    // Configurar el modo de error de PDO para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta SQL para obtener todos los registros de la tabla 'prediccion'
    $sql = 'SELECT dui, sistole, diastole, ingreso FROM prediccion';
    
    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Obtener todos los registros
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Mostrar los registros en una tabla HTML
    echo "
        <center> 
            <b>
                PREDICCION VALOR FUTURO TA
            </b>
        </center>
    ";
    echo '<table border="1" class="tablaDatos">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>DUI</th>';
    echo '<th>SISTOLE</th>';
    echo '<th>DIASTOLE</th>';
    echo '<th>FECHA</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    foreach ($records as $record) {
        echo '<tr>';
        echo '<td align="center">' . htmlspecialchars($record['dui']) . '</td>';
        echo '<td align="center">' . htmlspecialchars($record['sistole']) . '</td>';
        echo '<td align="center">' . htmlspecialchars($record['diastole']) . '</td>';
        echo '<td align="center">' . htmlspecialchars($record['ingreso']) . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    
} catch (PDOException $e) {
    // Manejar cualquier error de conexión o consulta
    echo 'Error: ' . $e->getMessage();
}

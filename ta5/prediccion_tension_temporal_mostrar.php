<?php
include_once "css.php";
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'ta';
$username = 'root';
$password = '';

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Establecer el modo de error de PDO para que use excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta SQL para seleccionar todos los registros de la tabla tmptension en orden ascendente por ingreso
    $query = "SELECT * FROM tmptension ORDER BY ingreso ASC";
    
    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    // Comenzar a generar la tabla HTML
    echo "<table border='1' class='tablaDatos'>";
    echo "<tr>
            <th>
                DUI
            </th>
            <th>
                SISTOLE
            </th>
            <th>
                DIASTOLE
            </th>
            <th>
                INGRESO
            </th>
        </tr>";
    
    // Obtener los resultados y mostrarlos en filas de la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['dui']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sistole']) . "</td>";
        echo "<td>" . htmlspecialchars($row['diastole']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ingreso']) . "</td>";
        echo "</tr>";
    }
    
    // Cerrar la tabla HTML
    echo "</table>";
    
} catch (PDOException $e) {
    // Mostrar un mensaje de error si la conexión falla o hay un problema con la consulta
    echo "Error: " . $e->getMessage();
}

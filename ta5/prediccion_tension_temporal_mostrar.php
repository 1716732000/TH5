<?php
include_once "css.php";

// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'ta';
$username = 'root';
$password = '';

// Definir el número de registros por página
$limit = 10;

// Obtener el número de página actual desde los parámetros GET, por defecto es la página 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Establecer el modo de error de PDO para que use excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta SQL para seleccionar los registros con límite y desplazamiento para paginación
    $query = "SELECT * FROM tmptension ORDER BY ingreso ASC LIMIT :limit OFFSET :offset";
    
    // Preparar la consulta
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Comenzar a generar la tabla HTML
    echo "<table border='1' class='tablaDatos'>";
    echo "<tr>
            <th>DUI</th>
            <th>SISTOLE</th>
            <th>DIASTOLE</th>
            <th>INGRESO</th>
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

    // Obtener el número total de registros para calcular el número de páginas
    $countQuery = "SELECT COUNT(*) FROM tmptension";
    $totalRecords = $pdo->query($countQuery)->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // Mostrar los enlaces de paginación
    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '">' . $i . '</a> ';
    }
    echo '</div>';
    
} catch (PDOException $e) {
    // Mostrar un mensaje de error si la conexión falla o hay un problema con la consulta
    echo "Error: " . $e->getMessage();
}
?>

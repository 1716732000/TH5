<?php
include_once "css.php";
try {
    // Conexión a la base de datos con PDO
    $pdo = new PDO("mysql:host=localhost;dbname=ta", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el valor de dui de la tabla tmppaciente
    $query = $pdo->query("SELECT dui FROM tmppaciente LIMIT 1");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Almacenar el valor en la variable $dui
    $dui = $result['dui'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


// Parámetros de la paginación
$limit = 17; // Máximo de registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ordenamiento
$order = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'ASC' : 'DESC';

try {
    // Preparar consulta para obtener registros según dui
    $stmt = $pdo->prepare("SELECT dui, sistole, diastole, ingreso FROM tension WHERE dui = :dui ORDER BY ingreso $order LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':dui', $dui, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Contar el total de registros
    $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM tension WHERE dui = :dui");
    $totalStmt->bindParam(':dui', $dui, PDO::PARAM_STR);
    $totalStmt->execute();
    $totalResults = $totalStmt->fetchColumn();
    $totalPages = ceil($totalResults / $limit);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!-- -------------------------------------------------------------------------->


<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Tensiones</title>
</head>
<body>

    <table border="1" class="tablaDatos">
        <thead>
            <tr>
                <th>DUI</th>
                <th>SISTOLE</th>
                <th>DIASTOLE</th>
                <th>
                    <a href="?page=<?php echo $page; ?>&order=<?php echo $order == 'ASC' ? 'desc' : 'asc'; ?>">
                        INGRESO
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)) : ?>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td align="left"><?php echo htmlspecialchars($row['dui']); ?></td>
                        <td align="left"><?php echo htmlspecialchars($row['sistole']); ?></td>
                        <td align="left"><?php echo htmlspecialchars($row['diastole']); ?></td>
                        <td align="left"><?php echo htmlspecialchars($row['ingreso']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No se encontraron registros.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?php echo $i; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>

</body>
</html>


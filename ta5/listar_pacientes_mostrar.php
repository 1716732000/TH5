<?php
include_once "css.php";

$host = 'localhost'; 
$dbname = 'ta';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seguridad para evitar SQL Injection
    $stmt = $pdo->prepare("SELECT dui, nombre, apellido, sexo, nacimiento, ingreso FROM paciente ORDER BY dui ASC");

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Paginación
    $total_records = count($result);
    $records_per_page = 20;
    $total_pages = ceil($total_records / $records_per_page);

    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $start_index = ($current_page - 1) * $records_per_page;

    $display_records = array_slice($result, $start_index, $records_per_page);

    // Calcular edad
    foreach ($display_records as &$record) {
        $nacimiento = new DateTime($record['nacimiento']);
        $hoy = new DateTime();
        $edad = $hoy->diff($nacimiento)->y;
        $record['edad'] = $edad;
    }
    unset($record);  // Desvincular referencia

    // Generar tabla HTML con ordenación
    echo "<table border='1' id='pacienteTable' class='tablaDatos'>
                <thead>
                    <tr>
                        <th onclick='sortTable(0)'>DUI</th>
                        <th onclick='sortTable(1)'>NOMBRE</th>
                        <th onclick='sortTable(2)'>APELLIDO</th>
                        <th onclick='sortTable(3)'>SEXO</th>
                        <th onclick='sortTable(4)'>NACIMIENTO</th>
                        <th onclick='sortTable(5)'>INGRESO</th>
                        <th onclick='sortTable(6)'>EDAD</th>
                    </tr>
                </thead>
            <tbody>";

            foreach ($display_records as $row) {
                echo "<tr>
                        <td>{$row['dui']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['apellido']}</td>
                        <td>{$row['sexo']}</td>
                        <td align='left'>{$row['nacimiento']}</td>
                        <td align='left'>{$row['ingreso']}</td>
                        <td align='left'>{$row['edad']}</td>
                    </tr>";
            }

        echo "</tbody>
        </table>";

    // Paginador
    echo "<div>";
    for ($page = 1; $page <= $total_pages; $page++) {
        echo "<a href='?page=$page'>$page</a> ";
    }
    echo "</div>";

    // Ordenar tabla usando JavaScript
    echo "
    <script>
    function sortTable(column) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById('pacienteTable');
        switching = true;
        dir = 'asc';
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName('TD')[column];
                y = rows[i + 1].getElementsByTagName('TD')[column];
                if (dir == 'asc') {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == 'desc') {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == 'asc') {
                    dir = 'desc';
                    switching = true;
                }
            }
        }
    }
    </script>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;  // Cerrar la conexión


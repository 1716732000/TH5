<?php
include_once "css.php";

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ta";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener todos los registros de la tabla 'prediccion'
$sql = "SELECT dui, msesistole, msediastole, ingreso FROM tmpmse";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear tabla HTML
    echo "<table border='1' class='table table-primary'>
            <tr>
                <th>DUI</th>
                <th>SISTOLE</th>
                <th>DIASTOLE</th>
                <th>FECHA</th>
            </tr>";
    
    // Mostrar los datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["dui"] . "</td>
                <td>" . $row["msesistole"] . "</td>
                <td>" . $row["msediastole"] . "</td>
                <td>" . $row["ingreso"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros.";
}

// Cerrar conexión
$conn->close();
?>

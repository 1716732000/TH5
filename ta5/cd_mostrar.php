<?php
include_once "css.php";
// Configuración de la conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'ta';

// Crear conexión a la base de datos
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta SQL para obtener los datos de tmpcd
$sql = "SELECT dui, cdsistole, cddiastole FROM tmpcd";
$resultado = $conexion->query($sql);

// Verificar si la consulta devuelve resultados
if ($resultado->num_rows > 0) {
    
    // Empezar la tabla HTML
    echo "<table border='1' class='table table-dark'>";
    echo "<thead><tr><th>DUI</th><th>CD Sístole</th><th>CD Diástole</th></tr></thead>";
    echo "<tbody>";

    // Mostrar cada fila de resultados
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td align='center'>" . htmlspecialchars($fila['dui']) . "</td>";
        echo "<td>" . htmlspecialchars(number_format($fila['cdsistole'], 3)) . "</td>";
        echo "<td>" . htmlspecialchars(number_format($fila['cddiastole'], 3)) . "</td>";
        echo "</tr>";
    }

    // Cerrar el cuerpo de la tabla y la tabla
    echo "</tbody>";
    echo "</table>";
} else {
    echo "No se encontraron registros en la tabla tmpcd.";
}

// Cerrar la conexión
$conexion->close();

<?php
include_once "css.php";

// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambia esto según tu configuración
$username = "root";   // Tu nombre de usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "ta"; // Tu nombre de base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta a la base de datos
$sql = "SELECT dui, nombre, apellido, sexo, nacimiento FROM tmppaciente"; // Ajusta la consulta según tu tabla
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    // Mostrar el error en caso de que la consulta falle
    die("Error en la consulta: " . $conn->error);
}

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Crear la tabla HTML
    echo "<table border='1' class='table table-dark'>";
    echo "<tr><th> DUI </th><th> NOMBRE </th><th> APELLIDO </th><th> SEXO </th><th> EDAD </th></tr>"; // Encabezados de la tabla

    // Mostrar los datos de cada fila
    while ($row = $result->fetch_assoc()) {
        // Calcular la edad a partir de la fecha de nacimiento (campo "nacimiento")
        $fechaNacimiento = new DateTime($row["nacimiento"]);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento)->y; // Calcular la diferencia en años

        echo "<tr>
                <td>" . htmlspecialchars($row["dui"]) . "</td>
                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                <td>" . htmlspecialchars($row["apellido"]) . "</td>
                <td>" . htmlspecialchars($row["sexo"]) . "</td>
                <td>" . htmlspecialchars($edad) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

// Cerrar la conexión
$conn->close();
?>

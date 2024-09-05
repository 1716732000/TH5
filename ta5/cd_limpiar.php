<?php
// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'ta';
$username = 'root';
$password = '';

// Crear una conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// SQL para vaciar la tabla
$sql = "TRUNCATE TABLE tmpcd";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    //echo "La tabla tmpcd ha sido vaciada exitosamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

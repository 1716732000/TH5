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

// SQL para vaciar la tabla tmpcd
$sqlcd = "TRUNCATE TABLE tmpcd";

// Ejecutar la consulta
if ($conn->query($sqlcd) === TRUE) {
    //echo "La tabla tmpcd ha sido vaciada exitosamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}

// SQL para vaciar la tabla tmpr2
$sqlr2 = "TRUNCATE TABLE tmpr2";

// Ejecutar la consulta
if ($conn->query($sqlr2) === TRUE) {
    //echo "La tabla tmpr2 ha sido vaciada exitosamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}

// SQL para vaciar la tabla tmpmse
$sqlmse = "TRUNCATE TABLE tmpmse";

// Ejecutar la consulta
if ($conn->query($sqlmse) === TRUE) {
    //echo "La tabla tmpmse ha sido vaciada exitosamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}

// SQL para vaciar la tabla tmprmse
$sqlmse = "TRUNCATE TABLE tmprmse";

// Ejecutar la consulta
if ($conn->query($sqlmse) === TRUE) {
    //echo "La tabla tmpmse ha sido vaciada exitosamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}

// SQL para vaciar la tabla tmpmae
$sqlmse = "TRUNCATE TABLE tmpmae";

// Ejecutar la consulta
if ($conn->query($sqlmse) === TRUE) {
    //echo "La tabla tmpmse ha sido vaciada exitosamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}



// Cerrar la conexión
$conn->close();

<?php
// Configuración de conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=ta';
$username = 'root';
$password = '';

try {
    // Conexión PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los datos ordenados por la columna "ingreso"
    $stmt = $pdo->query("SELECT dui, sistole, diastole, ingreso FROM tmptension ORDER BY ingreso DESC LIMIT 10" );

    // Almacenar los resultados en un array
    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

} catch (PDOException $e) {
    echo 'Error en la conexión: ' . $e->getMessage();
}
?>

<!-- ------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Tendencias de Tensión</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <center><b>TENDENCIA DE LA TENSION ARTERIAL</b></center>
    <br>
    <canvas id="tensionChart"></canvas>

    <script>
        // Datos obtenidos del backend en formato PHP convertido a JSON
        const data = <?php echo json_encode($data); ?>;

        // Arrays para almacenar los valores de ingreso, sistole y diastole
        const labels = data.map(item => item.ingreso);
        const sistoleValues = data.map(item => parseInt(item.sistole));
        const diastoleValues = data.map(item => parseInt(item.diastole));

        // Crear el gráfico usando Chart.js
        const ctx = document.getElementById('tensionChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Fechas de ingreso
                datasets: [{
                    label: 'Sistole',
                    data: sistoleValues,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                },
                {
                    label: 'Diastole',
                    data: diastoleValues,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha de Ingreso'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Tensión (mm Hg)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

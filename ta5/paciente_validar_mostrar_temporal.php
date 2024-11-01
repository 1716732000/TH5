<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
        ?>
    </head>
    <body>
        <table width="1100px" border="0">
            <tr>
                <td>
<!-- ------------------------------------------------------------------------->
                    <?php
                        // Configuración de la base de datos
                        $host = 'localhost';
                        $dbname = 'ta';
                        $username = 'root';
                        $password = '';

                        try {
                            // Conexión a la base de datos utilizando PDO
                            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                            // Configurar el manejo de errores de PDO para que lance excepciones
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Consulta SQL segura
                            $stmt = $pdo->prepare("SELECT dui, nombre, apellido, sexo, nacimiento, ingreso FROM tmppaciente");
                            $stmt->execute();

                            // Iniciar la tabla HTML
                            echo "&nbsp; &nbsp;";
                            echo "<table border='1' width='100%' class='tablaDatos'>
                                    <tr>
                                        <th>DUI</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>SEXO</th>
                                        <th>F / NACIMIENTO</th>
                                        <th>INGRESO</th>
                                        <th>EDAD</th>
                                    </tr>";

                            // Recorrer los resultados y calcular la edad
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $nacimiento = new DateTime($row['nacimiento']);
                                $hoy = new DateTime();
                                $edad = $hoy->diff($nacimiento)->y;

                                echo "<tr>
                                        <td align='left'>" . htmlspecialchars($row['dui']) . "</td>
                                        <td align='left'>" . htmlspecialchars($row['nombre']) . "</td>
                                        <td align='left'>" . htmlspecialchars($row['apellido']) . "</td>
                                        <td align='left'>" . htmlspecialchars($row['sexo']) . "</td>
                                        <td align='left'>" . htmlspecialchars($row['nacimiento']) . "</td>
                                        <td align='left'>" . htmlspecialchars($row['ingreso']) . "</td>
                                        <td align='left'>" . htmlspecialchars($edad) . "</td>
                                    </tr>";
                            }

                            // Cerrar la tabla HTML
                            echo "</table>";
                            echo "&nbsp; &nbsp;";

                        } catch (PDOException $e) {
                            // Manejo de errores
                            echo "Error: " . $e->getMessage();
                        }

                        // Cerrar la conexión
                        $pdo = null;
                    ?>
<!-- ------------------------------------------------------------------------->
                </td>
            </tr>
        </table>
    </body>
</html>
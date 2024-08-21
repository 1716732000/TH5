<!DOCTYPE html>
<html>
    <head>
        <?php            
            include_once "css.php";
         ?>
    </head>
    <body class="body">
        <center>
            <table border="0" width="1100px" class="tablaTemporal">
                <tr>
                    <td>
                        <CENTER> <B> CONFIRMACION ADICIO DE REGISTRO TA</B></CENTER>
                    </td>
                </tr>
            </table>
            <br>
        </center>

        <center>
            <table border="0" width="1100px" class="tablaTemporal">
                <tr>
                    <td>
                        <?php
                            include_once "paciente_validar_mostrar_temporal.php";   
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <?php
                            // Llamar funcion agregar registro de ta
                            AgregarTA()
                        ?>
                    </td>
                </tr>
            </table>
        </center>

    </body>
</html>


<?php
///////////////////////////////////////////////////////////////////////////
    function AgregarTA(){
//////////////////////////////////////////////////////////////////////////////////////////////////////
            // Obtener valores de $_REQUEST[]
            $sistole = $_REQUEST['txtSistole'];
            $diastole = $_REQUEST['txtDiastole'];

            try {
                // Conexión a la base de datos utilizando PDO
                $pdo = new PDO('mysql:host=localhost;dbname=ta', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Buscar el único registro en la tabla tmppaciente
                $query = "SELECT dui FROM tmppaciente LIMIT 1";
                $stmt = $pdo->query($query);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $dui = $result['dui'];

                    // Preparar la inserción en la tabla tension utilizando sentencias preparadas
                    $insertQuery = "INSERT INTO tension (dui, sistole, diastole) VALUES (:dui, :sistole, :diastole)";
                    $insertStmt = $pdo->prepare($insertQuery);

                    // Vincular los parámetros para evitar inyecciones SQL
                    $insertStmt->bindParam(':dui', $dui, PDO::PARAM_STR);
                    $insertStmt->bindParam(':sistole', $sistole, PDO::PARAM_INT);
                    $insertStmt->bindParam(':diastole', $diastole, PDO::PARAM_INT);

                    // Ejecutar la consulta de inserción
                    $insertStmt->execute();

                    echo "Datos insertados correctamente.";
                } else {
                    echo "No se encontró el registro en tmppaciente.";
                }
            } catch (PDOException $e) {
                // Manejo de errores
                echo "Error: " . $e->getMessage();
            }

}

////////////////////////////////////////////////////////////////////////////
?>

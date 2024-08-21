<?php
    try {
        // Conexión a la base de datos
        $dsn = 'mysql:host=localhost;dbname=ta';
        $username = 'root';
        $password = '';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $pdo = new PDO($dsn, $username, $password, $options);

        // Obtener Dui
        $dui = $_REQUEST['txtDui'];

        // Preparar la consulta para buscar el DUI en la tabla paciente
        $stmt = $pdo->prepare('SELECT * FROM paciente WHERE dui = :dui');
        $stmt->bindParam(':dui', $dui, PDO::PARAM_STR);
        $stmt->execute();

        // Verificar si se encontró algún registro
        if ($stmt->rowCount() > 0) {
            $registro = $stmt->fetch();

            // Preparar la consulta para insertar en la tabla tmppaciente
            $insertStmt = $pdo->prepare('INSERT INTO tmppaciente (dui, nombre, apellido, sexo, nacimiento, ingreso) VALUES (:dui, :nombre, :apellido, :sexo, :nacimiento, :ingreso)');
            $insertStmt->bindParam(':dui', $registro['dui'], PDO::PARAM_STR);
            $insertStmt->bindParam(':nombre', $registro['nombre'], PDO::PARAM_STR);
            $insertStmt->bindParam(':apellido', $registro['apellido'], PDO::PARAM_STR);
            $insertStmt->bindParam(':sexo', $registro['sexo'], PDO::PARAM_STR);
            $insertStmt->bindParam(':nacimiento', $registro['nacimiento'], PDO::PARAM_STR);
            $insertStmt->bindParam(':ingreso', $registro['ingreso'], PDO::PARAM_STR);
            $insertStmt->execute();

            //echo "Registro insertado en tmppaciente exitosamente.";
        } else {
            echo "Error: No se encontró ningún paciente con el DUI proporcionado.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

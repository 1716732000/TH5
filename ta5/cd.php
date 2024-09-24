<?php
    include_once "cd_limpiar.php";

    // Ruta al archivo Python
    $pythonFile = 'cd.py';

    // Ejecutar el archivo Python usando la función exec
    $output = [];
    $return_var = 0;
    exec("python $pythonFile", $output, $return_var);

    // Mostrar la salida del comando Python
    //echo "Salida del script Python:\n";
    foreach ($output as $line) {
        echo $line . "\n";
    }

    // Mostrar el código de retorno
    //echo "Código de retorno: $return_var\n";

    include_once "cd_mostrar.php";
    
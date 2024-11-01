<?php
    include_once "cd_limpiar.php";

    //Ejecutar eva_cd.py - Coefifiente de determinacion
    // Ruta al archivo Python 
    $pythonFile = 'eva_cd.py';

    // Ejecutar el archivo Python usando la función exec
    $output = [];
    $return_var = 0;
    exec("python $pythonFile", $output, $return_var);

    // Mostrar la salida del comando Python
    //echo "Salida del script Python:\n";
    foreach ($output as $line) {
        echo $line . "\n";
    }
    sleep(1);
/////////////////////////////////////////////////////////////////////////////////////

    //Ejecutar eva_mse.py - Error cuadratico medio
   // Ruta al archivo Python
   $pythonFile = 'eva_mse.py';

   // Ejecutar el archivo Python usando la función exec
   $output = [];
   $return_var = 0;
   exec("python $pythonFile", $output, $return_var);

   // Mostrar la salida del comando Python
   //echo "Salida del script Python:\n";
   foreach ($output as $line) {
       echo $line . "\n";
   }
   sleep(1);
//////////////////////////////////////////////////////////////////////////////////////

    
   //Ejecutar eva_mse.py - Error cuadratico medio
   // Ruta al archivo Python
   $pythonFile = 'eva_rmse.py';

   // Ejecutar el archivo Python usando la función exec
   $output = [];
   $return_var = 0;
   exec("python $pythonFile", $output, $return_var);

   // Mostrar la salida del comando Python
   //echo "Salida del script Python:\n";
   foreach ($output as $line) {
       echo $line . "\n";
   }
   sleep(1);
//////////////////////////////////////////////////////////////////////////////////////

//Ejecutar eva_mse.py - Error Absuloto
   // Ruta al archivo Python
   $pythonFile = 'eva_mae.py';

   // Ejecutar el archivo Python usando la función exec
   $output = [];
   $return_var = 0;
   exec("python $pythonFile", $output, $return_var);

   // Mostrar la salida del comando Python
   //echo "Salida del script Python:\n";
   foreach ($output as $line) {
       echo $line . "\n";
   }
   sleep(1);
//////////////////////////////////////////////////////////////////////////////////////



   
    // Mostrar el código de retorno
    //echo "Código de retorno: $return_var\n";

    //include_once "cd_mostrar.php";
    
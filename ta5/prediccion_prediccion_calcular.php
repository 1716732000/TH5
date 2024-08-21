<?php
// Ruta al archivo Python
$pythonFile = 'prediccion.py';

// Comando para ejecutar el archivo Python
$command = escapeshellcmd("python $pythonFile");

// Ejecuta el comando y captura la salida
$output = shell_exec($command);

// Muestra la salida (opcional)
echo "<pre>$output</pre>";

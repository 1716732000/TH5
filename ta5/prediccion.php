<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
        ?>
    </head>
    <body class="body">
        <center>
            <table width="1100px" class="tablaTemporal">
                <tr>
                    <td align="center">
                        <b>PREDICCION PROXIMO VALOR TA</b>
                    </td>
                </tr>
            </table>
            <br>
        </center>
        
        <center>
            <table width="1100px" class="tablaTemporal">
                <tr>
                    <td>
                        <?php
                            include_once "paciente_validar_mostrar_temporal.php";
                        ?>
                    </td>
                </tr>
            </table>
        </center>
        <br>

        <center>
            <table border="0" width="1100px" class="tablaTemporal">
                <tr>

                    <td rowspan="2" width="550px" valign="top">    
                        <center>
                            <b>LISTADO TA TEMPORAL</b>
                            
                        </center>                    
                        <?php
                            echo "<br>";
                            include_once "prediccion_truncar_temporal.php";
                            include_once "prediccion_tension_temporal_cargar.php";
                            include_once "prediccion_tension_temporal_mostrar.php";
                            
                            
                        ?>
                    </td>
                    <td  width="550px" valign="top">
                        <?php
                            include_once "chart.php";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td  width="550px" valign="top">                        
                        <?php
                            include_once "prediccion_factores_truncar.php";
                            
                            include_once "prediccion_factores_cargar.php";
                            
                            include_once "prediccion_prediccion_limpiar.php";
                            
                            include_once "prediccion_prediccion_calcular.php";
                            
                            include_once "prediccion_prediccion_mostrar.php";
                        ?>
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>




<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
        ?>
    </head>
    <body class="body">
    <center>
<!-- ----------------------------------------------------------------------------------->        
        <table width="1100px" class="tablaTemporal">
            <tr>
                <td align="center">
                    <b>FACTORES DE RIESGO EN PACIENTES HIPERTENSOS</b>
                </td>
            </tr>
        </table>
<!-- ----------------------------------------------------------------------------------->
        <br>
<!-- ----------------------------------------------------------------------------------->        
        <table width="1100px" class="tablaTemporal">
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                     <?php
                        include_once "paciente_validar_mostrar_temporal.php";
                        include_once "factores_agregar.php";
                     ?>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
<!-- ----------------------------------------------------------------------------------->
    </center>
    </body>
</html>
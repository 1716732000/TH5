<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
        ?>
    </head>
    <body class="body">
        <center>
        <table class="tablaTemporal">            
            <tr>
                <td align="center" style="height: 50px;">
                    <b>VALIDAR O AGREGAR PACIENTE</b>
                </td>
            </tr>
        </table>
        <br>
<!-- ------------------------------------------------------------------------------>        
        <table border="0" class="tablaTemporal">
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td width="3%"> </td>
                <td width="45%" valign="top" align="center">
                    <b>VALIDAR PACIENTE</b>
                    <?php
                        include_once "pacientes_validar.php";
                    ?>
                </td>

                <td width="4%" valign="top" align="center">
                    &nbsp;
                </td>

                <td width="45%" valign="top" align="center">
                    <b>AGREGAR PACIENTE</b>
                    <?php
                        include_once "pacientes_agregar.php";
                        
                    ?>
                </td>
                <td width="3%"> </td>
            </tr>
            <tr><td colspan="2"> &nbsp; </td></tr>
        </table>
<!-- ------------------------------------------------------------------------------>
        </center>
    </body>
</html>
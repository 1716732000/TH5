<!-- ACTUALIZAR FACTORES DE RIESGO -->
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
                        <b>HISTORIAL TA</b>
                    </td>
                </tr>
            </table>
            <br>
            <table width="1100px" class="tablaTemporal">
                <tr>
                    <td align="center">
                        <b>PACIENTE</b>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <?php
                            include_once "paciente_validar_mostrar_temporal.php";
                        ?>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td>
<!-- ----------------------------------------------------------------------------------->
                            <table border="0" width="1100px">
                                <tr>
                                    <td valign="top" width="525px">
                                        <?php
                                            include_once "listar_historial_mostrar.php";
                                        ?>
                                    </td>
                                    <td width="50px">&nbsp;</td>

                                    <td valign="top" width="525px">
                                        <?php
                                            include_once "tension.php";
                                        ?>
                                    </td>
                                </tr>
                            </table>

<!-- ----------------------------------------------------------------------------------->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
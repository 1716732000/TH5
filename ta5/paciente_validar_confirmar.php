<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
            $dui = $_REQUEST['txtDui'];
        ?>
    </head>
    <body class="body">
        <center>
<!-- ------------------------------------------------------------------------------>        
        <table class="tablaTemporal">
            <tr>
                <td style="height: 50px;">
                    CONFIRMACION DE PACIENTE
                </td>
            </tr>
        </table>     
        <br>   
<!-- ------------------------------------------------------------------------------>
        
        <table class="tablaTemporal">
            <tr><td> &nbsp;</td></tr>
            <tr>
                <td>
                  <?php
                    include_once "paciente_validar_truncar_temporal.php";
                    include_once "paciente_validar_cargar_temporal.php";
                    include_once "paciente_validar_mostrar_temporal.php";
                  ?>
                </td>
            </tr>
            <tr><td> &nbsp;</td></tr>
        </table>

    </center>
    </body>
</html>
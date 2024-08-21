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
                    <b>LISTADO GENERAL DE PACIENTES</b>
                </td>
            </tr>
        </table>
        <br>
<!-- ------------------------------------------------------------------------------>        
        <table border="0" class="tablaTemporal">
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <?php
                        include_once "listar_pacientes_mostrar.php";
                    ?>
                </td>
                <td>&nbsp;</td>                
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
<!-- ------------------------------------------------------------------------------>
        </center>
    </body>
</html>
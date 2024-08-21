<!DOCTYPE html>
<html>
    <head>
        <?php            
            include_once "css.php";
         ?>
    </head>
    <body>
        <form action="tension_confirmar.php" method="POST">
            <table border="0" width="100%" class="tablaAgregar">
                <tr><td>&nbsp;</td> <td></td></tr>

                <tr>
                    <td width="25%">
                        &nbsp;<B> SISTOLE: </B>
                    </td>
                    <td>
                        <input type="number" name="txtSistole" class="textoTA">
                    </td>
                </tr>
                <tr><td>&nbsp;</td> <td></td></tr>

                <tr>
                    <td>
                        &nbsp;<B> DIASTOLE: </B>
                    </td>
                    <td>
                        <input type="number" name="txtDiastole" class="textoTA">
                    </td>
                </tr>
                <tr><td>&nbsp;</td> <td></td></tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="btnAgregarSD" value="AGREGAR TA" class="botonAceptar">
                        &nbsp;
                        <input type="reset" name="btnCancelarSD" value="CANCELAR" class="botonCancelar">
                    </td> 
                    
                </tr>
                <tr><td>&nbsp;</td> <td></td></tr>
            </table>   
        </form> 
    </body>

</html>
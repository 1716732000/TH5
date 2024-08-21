<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
        ?>
    </head>
    <body>
        <br>
        <form action="paciente_validar_confirmar.php" method="POST">
            <table border="0" width="100%" class="tablaDatos">
                <tr><td colspan="2"> &nbsp; </td></tr>

                <tr>
                    <td width="25%">
                        &nbsp; <b>DUI :</b>
                    </td>
                    <td>
                        <input type="number" name="txtDui" class="textoDui" required>
                    </td>
                </tr>

                <tr><td colspan="2"> &nbsp; </td></tr>

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="btnValidat" value="VALIDAR PACIENTE" class="botonAceptar">
                    </td>
                </tr>

                <tr><td colspan="2"> &nbsp; </td></tr>
            </table>
        </form>
    </body>
</html>
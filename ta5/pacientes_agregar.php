<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
        ?>
    </head>
    <body>
        <br>
        <form action="pacientes_agregar_confirmar.php" method="POST">
            <table border="0" width="100%" class="tablaDatos">
                <tr><td colspan="2"> &nbsp; </td></tr>

                <tr>
                    <td width="35%">
                        &nbsp; <b>DUI :</b>
                    </td>
                    <td>
                        <input type="number" name="txtDui" min="0" class="textoDui" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        &nbsp; <b> NOMBRE :</b>
                    </td>
                    <td>
                        <input type="text" name="txtNombre" class="textoDatos" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        &nbsp; <b> APELLIDO :</b>
                    </td>
                    <td>
                        <input type="text" name="txtApellido" class="textoDatos" required>
                    </td>
                </tr>

                <tr>
                    <td>
                        &nbsp; <b> SEXO :</b>
                    </td>
                    <td>
                    <select id="genero" name="txtSexo" class="textoDui">
                        <option value="">Seleccionar Sexo</option>
                        <option value="MASCULINO">MASCULINO</option>
                        <option value="FEMENINO">FEMENINO</option>
                    </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        &nbsp; <b> F. NACIMIENTO :</b>
                    </td>
                    <td>
                        <input type="date" name="txtNacimiento" value="Fecha Nacimiento" class="textoDui"required>
                    </td>
                </tr>
                <tr><td colspan="2"> &nbsp; </td></tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="btnAgregarPaciente" value="AGREGAR PACIENTE" class="botonAceptar">
                        &nbsp;
                        <input type="reset" name="btnCancelarPaciente" value="CANCELAR" class="botonCancelar">
                    </td>
                </tr>
                <tr><td colspan="2"> &nbsp; </td></tr>
            </table>
        </form>
    </body>
</html>
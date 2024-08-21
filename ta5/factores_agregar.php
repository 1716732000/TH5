<!DOCTYPE html>
<html>
    <head>
        <?php
            include_once "css.php";
            include_once "factores_cargar_paciente.php";
        ?>
    </head>
    <body>
        <table border="0" width="550px">
            <tr>
                <td>
<!-- ----------------------------------------------------------------------------->  
                    <form action="factores_actualizar.php" method="POST">                
                        <table class="tablaDatos">
                            <tr><td>&nbsp;</td></tr>                            
                            <tr>
                                <td width="35%">
                                    &nbsp; HISTORIA:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtHistoria" class="textoFactores" value="<?php echo $historia; ?>" >
                                </td>
                                <td rowspan="7">
                                    &nbsp; 0 = Sin Riesgo       <br>
                                    &nbsp; 1 = Riesgo Leve      <br>
                                    &nbsp; 2 = Riesgo Moderado  <br>
                                    &nbsp; 3 = Riesgo Alto
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp; OBESIDAD:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtObesidad" class="textoFactores" value="<?php echo $obesidad; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp; SEDENTARISMO:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtSedentarismo" class="textoFactores" value="<?php echo $sedentarismo; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp; ALCOHOLISMO:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtAlcoholismo" class="textoFactores" value="<?php echo $alcoholismo; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp; TABAQUISMO:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtTabaquismo" class="textoFactores" value="<?php echo $tabaquismo; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp; DIABETES:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtDiabetes" class="textoFactores" value="<?php echo $diabetes; ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp; COLESTEROL:
                                </td>
                                <td>
                                    <input type="number" min="0" max="3" name="txtColesterol" class="textoFactores" value="<?php echo $colesterol; ?>">
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td colspan="3" align="center">
                                    <input type="submit" name="btnActualizar" value="ACTUALIZAR" class="botonAceptar">
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </form>                      
<!-- ----------------------------------------------------------------------------->
                </td>
            </tr>
        </table>
    </body>
</html>
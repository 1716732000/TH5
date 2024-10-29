<title>
    METRICAS - SANGUINEM PRESSURA
</title>
<table border="1" width="70%" align="center">
    <tr>
        <td colspan="2">
           <center>
                <h3>
                    <b>METRICAS</b>
                </h3>
           </center>
        </td>
    </tr>
    <tr>
        <td colspan="2">
           &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="2">
           <b>DATOS DEL PACIENTE</b>
           <br>
           <?php
                require_once "paciente.php";
           ?>
        </td>
    </tr>
    <tr>
        <td width="50%">
            &nbsp;
            <b> PREDICCION </b>
            <?php
                require_once "prediccion.php";
           ?>
        </td>
        <td width="50%">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td width="50%">
            &nbsp;
            <b>COEFICIENTE DE DETERMINACION (R<sup>2</sup>)</b>
            <?php
                require_once "cdr2.php";
           ?>
        </td>
        <td width="50%">
            &nbsp;
            <B>ERROR CUADRATICO MEDIO (MSE)</B>
            <?php
                require_once "mse.php";
           ?>
        </td>
    </tr>
    <tr>
        <td width="50%">
            &nbsp;
            <B>RAIZ DEL ERROR CUADRATICO MEDIO (RMSE)</B>
            <?php
                require_once "rmse.php";
           ?>
        </td>
        <td width="50%">
            &nbsp;
            <B>ERROR ABSOLUTO MEDIO (MAE)</B>
            <?php
                require_once "mae.php";
           ?>
        </td>
    </tr>
    <tr>
        <td width="50%">
            &nbsp;
        </td>
        <td width="50%">
            &nbsp;
        </td>
    </tr>
</table>
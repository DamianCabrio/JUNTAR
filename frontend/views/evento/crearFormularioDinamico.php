<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<script type="text/javascript">
    function add_row()
    {
        $rowno=$("#employee_table tr").length;
        $rowno=$rowno+1;

        if($rowno >= 10){

        }

        $("#employee_table tr:last").after("<tr id='row"+$rowno+"'>" +
            "<td> <select name='tipo[]' id=''> <option value='1'>Respuesta corta</option> <option value='2'>Respuesta larga</option> <option value='3'>Opciones</option> </select></td>" +
            "<td><input type='text' name='pregunta[]' placeholder='Ingrese la pregunta'></td>" +
            "<td><input type='button' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>");
    }
    function delete_row(rowno)
    {
        $('#'+rowno).remove();
    }
</script>

<div class="crear-formulario container">
    <div id="form_div">
        <form method="post" action="store_detail.php">
            <input type="button" onclick="add_row();" value="ADD ROW">
            <input type="submit" name="submit_row" value="SUBMIT">
            <table id="employee_table" align=center>
                <tr id="row1">
                    <td>
                        <select name="tipo[]" id="">
                            <option value="1">Respuesta corta</option>
                            <option value="2">Respuesta larga</option>
                            <option value="3">Opciones</option>
                        </select>
                    </td>
                    <td><input type='text' name='pregunta[]' placeholder='Ingrese la pregunta'></td>
                </tr>
            </table>
        </form>
    </div>
</div>
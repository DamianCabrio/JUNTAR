<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>

<div class="crear-formulario container">
    <div id="form_div">
        <?php $form = ActiveForm::begin(['method' => "post", "id" => "dinamicForm"]); ?>
        <?= $form->field($model,"botonAgregar")->input("button", ["onclick" => "add_row();", "value" => "Agregar Pregunta"])->label(false) ?>
        <?= Html::submitButton("Enviar", ["id" => "submit", "name"=> "submit_row"]) ?>
            <table id="tabla_preguntas" align=center>
                <tr id="row1">
                    <td>
                        <?php $valores = ["Respuesta corta", "Respuesta larga", "Opciones"] ?>
                        <?= $form->field($model,"tipo[]")->dropDownList($valores, ["prompt" => "Elige un tipo", "id" => "select1", "onchange" => "checkOptions(this)"])->label(false); ?>
                    </td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
    </div>
</div>

<script type="text/javascript">
    function add_row()
    {
        if (typeof $rowno === 'undefined') {
            $rowno = 1
        }
        $rowno=$("#tabla_preguntas tr").length;
        $rowno=$rowno+1;
        if($rowno <= 10){

            $("#tabla_preguntas tr:last").after("<tr id='row"+$rowno+"'>" +
                "<td> " +
                '<?= preg_replace( "/\r|\n/", "", $form->field($model,'tipo[]')->dropDownList($valores, ['prompt' => 'Elige un tipo', 'id' => 'select1', 'onchange' => 'checkOptions(this)'])->label(false) ); ?>' +
                "</td>"+
                "<td><input type='button' value='Eliminar pregunta' onclick=delete_row('row"+$rowno+"')></td></tr>");

            $("#tabla_preguntas tr:last td div select").attr("id", "select"+$rowno);
        }
        else if ($rowno > 10 && $("#formularioform-botonagregar").not(":hidden")){
            $("#formularioform-botonagregar").hide();
        }
        console.log("after:", $rowno);
    }

    function echoNombrePregunta(id){
        return "<td id='pregunta"+ id +"'><input type='text' name='pregunta[]' placeholder='Ingrese la pregunta'></td>";
    }

    function echoNombrePreguntaYOpciones(id){
        return "<td id='pregunta"+ id +"'><input type='text' name='pregunta[]' placeholder='Ingrese la pregunta'></td>";
    }

    function checkOptions(element) {
        if(element.value == 2){

        }else if(element.value != 2 && $("#pregunta"+element.id).length === 0){
            $("#"+element.id).after(echoNombrePregunta(element.id));
        }else if (element.value == ""){
            $('#pregunta' + element.id).remove();
        }
    }

    function delete_row(rowno)
    {
        $('#'+rowno).remove();
        if($rowno > 10 && $("#formularioform-botonagregar").is(":hidden")) {
            $("#formularioform-botonagregar").show();
        }
    }
</script>
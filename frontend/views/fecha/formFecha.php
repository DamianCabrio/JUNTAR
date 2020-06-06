<?php

use frontend\models\Evento;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;



/* @var $this yii\web\View */
/* @var $model frontend\models\Fecha */
/* @var $form ActiveForm */
?>
<div class="fecha-formFecha">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    $item = Evento::find()
        ->select(['nombreEvento'])
        ->indexBy('idEvento')
        ->column();
    ?>
    <?= $form->field($model, 'idEvento')->dropdownList( $item, ['prompt' => 'Elija una Evento'])->label('Evento') ?>
    <label for="cantDias"> Cantidad de Dias del Evento</label>
    
    <?= $form->field($model, 'fecha')->input('date')
    //widget(DatePicker::className(), [
    //    'language' => 'es',
    //    'dateFormat' => 'yyyy-MM-dd',
    //]) 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- fecha-formFecha -->
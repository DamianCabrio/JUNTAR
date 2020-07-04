<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model LoginForm */

use common\models\LoginForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="m-auto">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <div class="row card-body">
                <div class="col-md-5 col-sm-12 m-auto">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'email')->input('email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'showpw', ['options' => ['class' => 'showpw']])->checkBox()->label("Mostrar Contraseña") ?>

                    <?= $form->field($model, 'rememberMe')->checkbox()->label("Recordarme") ?>

                    <div class="form-group">
                        <?= Html::submitButton('Ingresar', ['class' => 'btn btn-pink col-md-4 col-sm-12', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

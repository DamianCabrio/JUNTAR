<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">

    <div class="body-content">
        <img width="400px" height="400px" src="<?php echo $imageQR ?>" title="<?= Html::encode($slug); ?>">
    </div>
</div>
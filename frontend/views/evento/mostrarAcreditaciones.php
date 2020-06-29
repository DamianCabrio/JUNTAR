<?php
/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">

    <div class="body-content">
        <img width="400px" height="400px" src="<?php echo $imageQR ?>" title="<?= Html::encode($slug); ?>">
    </div>
</div>
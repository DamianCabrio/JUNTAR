<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Sobre Nosotros';
$this->params['breadcrumbs'][] = $this->title;

//print_r($user);
//print_r($broma);
//shuffle($arrayProfes);
//echo $info['image'];
//shuffle($arrayUsers);
?>

<!--<div class="container-fluid dark_light_bg">-->
    <?php if (!is_array($info)): ?>
        <?php print_r($info); ?>
    <?php else: ?>
        <!--<div class="container">-->
            <div class="row p-0">
                <div class="col-md-5 col-sm-12 text-center">
                    <?php if ((@getimagesize($info['image']))): ?>
                        <img class="full_width" src="<?php echo "../" . Html::encode($info['image']); ?>"></img>
                    <?php else: ?>
                        <img class="full_width filter-white" src="../iconos/person-circle.svg"></img>
                    <?php endif; ?>
                </div>
                <div class="col-md-7 col-sm-12 d-flex align-items-center"> 
                    <span class="align-middle m-auto">
                        <p class="text-white"> 
                            <img class="filter-white" src="../iconos/email.svg" alt="Email" title="Email" width="30" height="30" role="img"> <?php echo Html::encode($info['email']); ?> 
                        </p>
                    </span>
                </div> 
            </div>
        <!--</div>-->
    <?php endif; ?>
<!--</div>-->




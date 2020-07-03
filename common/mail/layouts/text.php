<?php

/** @var View $this view component instance */

use yii\mail\MessageInterface;
use yii\web\View;

/** @var MessageInterface $message the message being composed */
/** @var string $content main view render result */
?>

<?php $this->beginPage() ?>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>

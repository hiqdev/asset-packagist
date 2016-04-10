<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You can contact us in several ways:
        <ul>
            <li><a href="https://github.com/hiqdev/asset-packagist.hiqdev.com/issues">GitHub issues</a> - this is the preferred way, you can contribute too</li>
            <li>my email: <a href="mailto:sol@hiqdev.com">sol@hiqdev.com</a></li>
        </ul>
    </p>
</div>

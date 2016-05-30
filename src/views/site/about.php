<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Here is going to be more information on how it works.</p>

    <p>Basically it provides information on Bower and NPM packages in the same way as Packagist does it for Composer packages.</p>

    <h1>Acknowledgements</h1>

    <p>This project uses Francois Pluchino's <a href="https://github.com/francoispluchino/composer-asset-plugin">composer-asset-plugin</a> to convert Bower and NPM packages to Composer format.</p>
</div>

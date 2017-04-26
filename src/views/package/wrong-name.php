<?php

/**
 * @var yii\web\View view object
 * @var string $query the search query that was submitted
 * @var bool $forceUpdate Whether the application must force package update
 */
use yii\helpers\Html;

$this->title = 'Not found';

?>

<div class="package-details">
    <h1>
        <?= $this->title ?>
    </h1>

    <h3>Try one of the following links:</h3>
    <ul class="h4">
        <li><?= Html::a('bower-asset/' . $query, ['/package/search', 'query' => 'bower-asset/' . $query]) ?></li>
        <li><?= Html::a('npm-asset/' . $query, ['/package/search', 'query' => 'npm-asset/' . $query]) ?></li>
    </ul>
</div>

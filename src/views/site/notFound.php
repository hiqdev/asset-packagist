<?php

/**
 * @var yii\web\View view object
 * @var string $query the search query that was submitted
 * @var hiqdev\assetpackagist\models\AssetPackage $package
 * @var bool $forceUpdate Whether the application must force package update
 */
$this->title = 'Not found';
$this->params['searchQuery'] = $query;

?>

<div class="package-details">
    <h1>
        <?= $this->title ?>
    </h1>
    <h1>
        <small class="repository-link">
            Please use: <a href="/site/search?query=bower-asset/<?= $query ?>">bower-asset/<?= $query ?></a> or
                        <a href="/site/search?query=npm-asset/<?= $query ?>">npm-asset/<?= $query ?></a>
        </small>
    </h1>
</div>

<?php

use hiqdev\assetpackagist\models\AssetPackage;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = \hiqdev\assetpackagist\assets\AppAsset::register($this);
$logoUrl = $bundle->baseUrl . '/logo';
$package = new AssetPackage(strtolower($model->platform), $model->name);

$url = Url::to(['package/detail', 'fullname' =>  $package->fullName]);
$url = str_replace('%2F', '/', $url);
?>
<div class="row well well-sm">
    <div class="col-sm-9">
        <h4 class="search-result-item-heading">
            <img src="<?= $logoUrl . '/' . strtolower($model->platform) ?>.svg" title="<?= Html::encode($model->platform) ?>" height="20px" />
            <a href="<?= $url ?>"><?= Html::encode($package->fullName) ?></a>
        </h4>
        <?php if ($model->description): ?>
            <p class="description"><?= Html::encode($model->description) ?></p>
        <?php endif ?>
        <?php if ($model->latest_release_number): ?>
            <p class="latest_release_number">
                Latest Release: <span class="label label-success"><?= Html::encode($model->latest_release_number) ?></span>
                <?php if ($model->latest_release_published_at): ?>
                at <?= Yii::$app->formatter->asDateTime($model->latest_release_published_at) ?>
                (<?= Yii::$app->formatter->asRelativeTime($model->latest_release_published_at)?>)
                <?php endif ?>
            </p>
        <?php endif ?>
        <?php if (!empty($model->keywords)): ?>
            <p class="keywords">
                Keywords: 
                <?= '<span class="label label-default">' . implode('</span> <span class="label label-default">', $model->keywords) . '</span>' ?>
            </p>
        <?php endif ?>
    </div>
    <div class="col-sm-3 text-align-center">
        <?php if ($model->homepage): ?>
            <p class="homepage">
                <a href="<?= Html::encode($model->homepage) ?>" target="_blank">
                    <i class="glyphicon glyphicon-globe" aria-hidden="true"></i> Homepage
                </a>
            </p>
        <?php endif ?>
        <?php if ($model->repository_url): ?>
            <p class="repository_url">
                <a href="<?= Html::encode($model->repository_url) ?>" target="_blank">
                    <i class="glyphicon glyphicon-random" aria-hidden="true"></i> Repository
                </a>
            </p>
        <?php endif ?>
        <?php if (!empty($model->normalized_licenses)): ?>
            <p class="normalized_licenses">
                <i class="fa fa-balance-scale"></i> License:
                <?= implode(',', $model->normalized_licenses) ?>
            </p>
        <?php endif ?>
        <?php if ($package->isAvailable()): ?>
            <a class="btn btn-success btn-sm" href="<?= $url ?>">Ready to use</a>
        <?php else: ?>
            <a class="btn btn-warning btn-sm" href="<?= $url ?>">Fetch</a>
        <?php endif ?>
    </div>
</div>

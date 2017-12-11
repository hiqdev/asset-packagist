<?php

use hiqdev\assetpackagist\librariesio\ProjectDataProvider;
use yii\widgets\ListView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $query string */
/* @var $platform string */
/* @var $dataProvider ProjectDataProvider */

$query = Html::encode($query);

$this->title = 'Results for "' . $query . '"';
$this->params['searchQuery'] = $query;
$this->params['searchPlatform'] = $platform;
$this->params['subtitle'] = $query;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="package-search">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_search_item',
        'layout' => "{summary}\n{items}\n{pager}",
    ]) ?>
</div>

<?php

/**
 * @var $this yii\web\View
 * @var string $query the search query that was submitted
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 * @var bool $forceUpdate Whether the application must force package update
 */

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchQuery'] = $query;

?>

    <div class="package-details">
        <h1>
            <?= Html::encode($package->getFullName()) ?>
            <small class="repository-link">
                <?php
                echo Html::a(
                    Yii::t('app', 'see on {registry}', ['registry' => Inflector::titleize($package->getType())]),
                    $package->getRegistry()->getPackageSearchUrl($package->getName())
                ) ?>
            </small>
        </h1>
        <?= Html::button(Yii::t('app', 'Fetch updates from {registry}', [
            'registry' => Inflector::titleize($package->getType()),
        ]), [
            'id' => 'fetch-btn',
            'type' => 'button',
            'class' => 'btn btn-success fetch-btn pull-right',
            'data-loading-text' => Yii::t('app', 'Fetching for you...'),
        ]) ?>

        <?= $this->render('package-details', ['package' => $package]); ?>
    </div>

<?php
$options = Json::encode([
    'url' => Url::to('update'),
    'type' => 'post',
    'data' => [
        'query' => $package->getFullName()
    ],
    'success' => new \yii\web\JsExpression("function (html) {
        versions.removeClass('updating').html(html);
        btn.button('reset');
    }"),
    'beforeSend' => new \yii\web\JsExpression("function (event) {
        versions.addClass('updating').html($('<i class=\"fa fa-cog fa-spin fa-3x fa-fw\"></i>'));
        btn.button('loading');
    }")
]);

$this->registerJs(<<<JS
    $('#fetch-btn').on('click', function () {
        var versions = $('.versions'), btn = $('#fetch-btn');
        $.ajax($options);
    })
JS
);

if ($forceUpdate) {
    $this->registerJs("$('#fetch-btn').trigger('click')");
}

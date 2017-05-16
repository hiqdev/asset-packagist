<?php

/**
 * @var yii\web\View $this
 * @var string $query the search query that was submitted
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 * @var bool $forceUpdate Whether the application must force package update
 */
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Search';
$this->params['searchQuery'] = $query;
$this->params['subtitle'] = $query;
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="package-details">
        <h1>
            <?= Html::encode($package->getFullName()) ?>
            <small class="repository-link">
                <?php
                if ($package->getType() === 'npm') {
                    $link = 'https://npmjs.com/package/' . $package->getName();
                } elseif ($package->getType() === 'bower') {
                    $link = 'https://bower.io/search?q=' . $package->getName();
                }
                echo Html::a(
                    Yii::t('app', 'see on {registry}', ['registry' => Inflector::titleize($package->getType())]),
                    $link
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

        <?= $this->render('details', ['package' => $package]); ?>
    </div>

<?php
$options = Json::encode([
    'url' => Url::to(['update']),
    'type' => 'post',
    'data' => [
        'query' => $package->getFullName(),
    ],
    'success' => new \yii\web\JsExpression("function (html) {
        versions.removeClass('updating').html(html);
        btn.button('reset');
    }"),
    'beforeSend' => new \yii\web\JsExpression("function (event) {
        versions.addClass('updating').html($('<i class=\"fa fa-cog fa-spin fa-3x fa-fw\"></i>'));
        btn.button('loading');
    }"),
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

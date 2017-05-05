<?php

use hiqdev\assetpackagist\assets\AppAsset;
use hiqdev\thememanager\menus\AbstractMainMenu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

$bundle = AppAsset::register($this);

$this->registerCss('
/* Important styles, do not remove */
@media (min-width: 768px) {
    #query {
        width: 270px;
    }
}
@media (min-width: 1024px) {
    #query {
        width: 450px;
    }
}
');

?>
<?php NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]) ?>
<?= AbstractMainMenu::widget([], [
    'class' => Nav::class,
    'options' => ['class' => 'navbar-nav navbar-right'],
]) ?>

<?= Html::beginForm('/package/search', 'GET', ['id' => 'search-form', 'class' => 'navbar-form navbar-right', 'autocomplete' => 'off']) ?>
    <div class="form-group has-feedback">
        <?= Html::input('text', 'query', (isset($this->params['searchQuery']) ? $this->params['searchQuery'] : ''), [
            'id' => 'query',
            'required' => true,
            'autocomplete' => false,
            'placeholder' => 'bower-asset/package-name to add or check',
            'class' => 'form-control',
            'autofocus' => true,
            'tabindex' => 1,
        ]) ?>
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>
    <?= Html::endForm() ?>
<?php NavBar::end() ?>

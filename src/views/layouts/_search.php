<?php
/**
 * @var View $this
 */
use yii\helpers\Html;
use yii\web\View;

?>

<section style="clear:both;background-color:#eee">
    <br><br><br>
    <div class="container">
        <div class="col-xs-12 col-md-9" style="padding:0px 0 10px 0">
            <?= Html::beginForm('site/search', 'GET', ['id' => 'search-form']) ?>
            <?= Html::input('text', 'query', $this->params['searchQuery'], [
                'id' => 'query',
                'required' => true,
                'autocomplete' => false,
                'placeholder' => 'bower-asset/package-name to add/check',
                'class' => 'form-control'
            ]) ?>
            <?= Html::endForm(); ?>
        </div>
    </div>
</section>


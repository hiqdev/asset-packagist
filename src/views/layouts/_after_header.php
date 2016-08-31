<?php

use yii\helpers\Html;

?>
<div style="background-color:#eee">
    <div class="container">
        <div class="row">
            <div class="col-xs-12" style="padding-top:10px;padding-bottom:10px">
                <?= Html::beginForm('/site/search', 'GET', ['id' => 'search-form']) ?>
                <?= Html::input('text', 'query', (isset($this->params['searchQuery']) ? $this->params['searchQuery'] : ''), [
                    'id' => 'query',
                    'required' => true,
                    'autocomplete' => false,
                    'placeholder' => 'bower-asset/package-name to add/check',
                    'class' => 'form-control',
                ]) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>

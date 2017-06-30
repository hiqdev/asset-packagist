<?php

use yii\helpers\Html;

$this->registerCss('
/* Important styles, do not remove */
#query {
    width: 60%;
}
#platform {
    width: 39%;
}
@media (min-width: 768px) {
    #query {
        width: 270px;
    }
    #platform {
        width: 100px;
    }
}
@media (min-width: 1024px) {
    #query {
        width: 450px;
    }
    #platform {
        width: 100px;
    }
}
');

?>

<?= Html::beginForm(['/package/search'], 'GET', ['id' => 'search-form', 'class' => 'navbar-form navbar-right', 'autocomplete' => 'off']) ?>
    <div class="form-group">
        <div class="input-group">
            <?= Html::input('text', 'query', (isset($this->params['searchQuery']) ? $this->params['searchQuery'] : ''), [
                'id' => 'query',
                'required' => true,
                'autocomplete' => false,
                'placeholder' => 'package name to search, powered by libraries.io',
                'class' => 'form-control',
                'autofocus' => true,
                'tabindex' => 1,
            ]) ?>
            <?= Html::dropDownList('platform', (isset($this->params['searchPlatform']) ? $this->params['searchPlatform'] : 'bower,npm'), [
                'bower,npm'   => 'Any',
                'bower' => 'Bower',
                'npm'   => 'NPM',
                    ], [
                'id'    => 'platform',
                'class' => 'form-control',
                'tabindex' => 2,
            ]) ?>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default" tabindex="3">
                    &nbsp;<span class="fa fa-search" aria-hidden="true"></span>
                </button>
            </span>
        </div>
    </div>
<?= Html::endForm() ?>

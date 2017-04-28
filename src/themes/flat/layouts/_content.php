<?= \hiqdev\thememanager\widgets\Flashes::widget() ?>

<?php if (Yii::$app->themeManager->isHomePage()) : ?>
    <div class="container">
        <?= $content ?>
    </div>
<?php else: ?>
    <section id="<?= isset($this->params['contentId']) ? $this->params['contentId'] : 'content' ?>" class="container">
        <?= $content ?>
    </section>
<?php endif ?>

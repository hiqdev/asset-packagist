<?php

/**
 * @var $this yii\web\View
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 */
use yii\helpers\Html;

?>

<?php $releases = $package->getReleases() ?>

<div class="versions">
    <?php if (!empty($releases)) { ?>
        <?= Html::tag('div', Yii::t('app', '✔ This package is OK to use!'), [
            'class' => 'package-ok'
        ]) ?>
    <?php } ?>

    <br><br>
    <b>Last updated:</b> <?= Yii::$app->formatter->asDateTime($package->getUpdateTime()) ?> (<?= Yii::$app->formatter->asRelativeTime($package->getUpdateTime()) ?>)
    <br><br>

    <?php if (Yii::$app->session->hasFlash('update-impossible')) { ?>
        <div class="alert alert-warning too-fast-update" role="alert">
            <h4><?= Yii::t('app', 'Wow, you are very fast!'); ?></h4>
            <p><?= Yii::t('app',
                    'The package was updated recently. Could you wait another 10 minutes before fetching it again, please?') ?></p>
        </div>
        <?php
        Yii::$app->session->removeFlash('update-impossible');
    } ?>

    <table class="table">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Version') ?></th>
            <th colspan="2"><?= Yii::t('app', 'Commit SHA') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ((array)$releases as $version => $release) : ?>
            <tr>
                <th><?= $version ?></th>
                <td><code><?= $release['source']['reference'] ?: $release['dist']['reference'] ?></code></td>
                <td>
                    <?php
                    $links = [];
                    if ($release['dist']['url']) {
                        $links[] = Html::a(Yii::t('app', 'Get ZIP'), $release['dist']['url']);
                    }
                    if ($release['source']['url']) {
                        $links[] = Html::a(Yii::t('app', 'see sources'), $release['source']['url']);
                    }

                    echo implode(' or ', $links);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

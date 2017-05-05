<?php

/**
 * @var yii\web\View
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 */
use Composer\Semver\Comparator;
use Composer\Semver\VersionParser;
use yii\helpers\Html;

?>

<?php
$releases = $package->getReleases();

uasort($releases, function ($a, $b) {
    if ($a['version'] === $b['version']) {
        return 0;
    }

    $stability_a = VersionParser::parseStability($a['version_normalized']);
    $stability_b = VersionParser::parseStability($b['version_normalized']);

    // DEV versions to LAST
    if ($stability_a === 'dev' && $stability_b !== 'dev') {
        return 1;
    } elseif ($stability_a !== 'dev' && $stability_b === 'dev') {
        return -1;
    }

    if (Comparator::lessThan($a['version_normalized'], $b['version_normalized'])) {
        return 1;
    }

    return -1;
});

$stability_colors = [
    'stable' => 'success',
    'RC' => 'primary',
    'beta' => 'info',
    'alpha' => 'warning',
    'dev' => 'default',
];
?>

<div class="versions">
    <?php if (!empty($releases)) : ?>
        <?= Html::tag('div', Yii::t('app', '✔ This package is OK to use!'), [
            'class' => 'package-ok',
        ]) ?>
    <?php endif ?>

    <br><br>
    <b>Last updated:</b> <?= Yii::$app->formatter->asDateTime($package->getUpdateTime()) ?> (<?= Yii::$app->formatter->asRelativeTime($package->getUpdateTime()) ?>)
    <br>
    <b>Legend:</b>
    <?php foreach ($stability_colors as $stability => $color) : ?>
        <?= Html::tag('span', $stability, ['class' => 'label label-' . $color]) . ' ' ?>
    <?php endforeach ?>
    <br><br>

    <?php if (Yii::$app->session->hasFlash('rate-limited')) : ?>
        <div class="alert alert-warning too-fast-update" role="alert">
            <h4><?= Yii::t('app', 'Wow, you are very fast!') ?></h4>
            <p><?= Yii::t('app', 'The package was updated recently. Could you wait another 10 minutes before fetching it again, please?') ?></p>
        </div>
        <?php Yii::$app->session->removeFlash('rate-limited') ?>
    <?php endif ?>

    <table class="table">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Version') ?></th>
            <th colspan="2"><?= Yii::t('app', 'Commit SHA') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ((array) $releases as $version => $release) : ?>
            <tr>
                <th>
                    <?php 
                        $stability = VersionParser::parseStability($release['version_normalized']);
                        echo Html::tag('span', $version, ['class' => 'label label-' . $stability_colors[$stability]]);
                    ?>
                </th>
                <td>
                    <code><?= $release['source']['reference'] ?: $release['dist']['reference'] ?: 'n/a' ?></code>
                </td>
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
        <?php endforeach ?>
        </tbody>
    </table>
</div>

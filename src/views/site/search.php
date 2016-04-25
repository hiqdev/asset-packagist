<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($package->getFullName()) ?></h1>

    <p>
        <?php $releases = (array)$package->getReleases() ?>
        <table>
        <?php foreach ($releases as $version => $release) : ?>
            <tr>
                <th><?= $version ?></th>
                <td><code><?= $release['source']['reference'] ?: $release['dist']['reference'] ?></code></td>
            </tr>
        <?php endforeach ?>
        </table>
    </p>
</div>

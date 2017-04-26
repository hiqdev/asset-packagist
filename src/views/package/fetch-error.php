<?php

/**
 * @var \yii\web\View $this
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 * @var \Composer\Repository\InvalidRepositoryException $exception
 */

use yii\helpers\Html;

$this->title = 'Package update failed';

?>
<hr/>
<h3><?= $this->title ?></h3>

<blockquote><?= $exception->getMessage() ?></blockquote>

<?php

if ($package->getType() === 'npm') {
    $link = Html::a('npmjs.com', 'https://npmjs.com/search?q=' . $package->getName(), ['target' => '_blank']);
} elseif ($package->getType() === 'bower') {
    $link = Html::a('bower.io', 'https://bower.io/search?q=' . $package->getName(), ['target' => '_blank']);
}

?>

<h4>Could you ensure this package exists on <?= $link ?> ?</h4>
<p>Think asset-packagist is guilty? <?= Html::a('Report on GitHub', 'https://github.com/hiqdev/asset-packagist/issues/new') ?>
</p>

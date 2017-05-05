<?php

/**
 * @var \yii\web\View
 * @var \hiqdev\assetpackagist\models\AssetPackage $package
 */
use yii\helpers\Html;

$this->title = 'Oops... Package was not found';

?>
<hr/>
<h3><?= $this->title ?></h3>

<?php

if ($package->getType() === 'npm') {
    $link = Html::a('npmjs.com', 'https://npmjs.com/search?q=' . $package->getName(), ['target' => '_blank']);
} elseif ($package->getType() === 'bower') {
    $link = Html::a('bower.io', 'https://bower.io/search?q=' . $package->getName(), ['target' => '_blank']);
}

?>

<h4>Could you ensure this package exists on <?= $link ?>?</h4>
<p> In case it exists, but still can not be obtained by asset-packagist &mdash;
    <?= Html::a('report on GitHub', 'https://github.com/hiqdev/asset-packagist/issues/new') ?>
</p>

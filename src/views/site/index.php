<?php

use hiqdev\assetpackagist\assets\AppAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */
$bundle = AppAsset::register($this);
$logoUrl = $bundle->baseUrl . '/logo';

$this->title = Yii::$app->name;
$this->params['noTitle'] = true;

?>
<div class="container site-index">
    <div style="text-align:center;margin:30px 0px 20px">
        <div>
            <img src="<?= $logoUrl ?>/composer.png" height="140px">
            <img src="<?= $logoUrl ?>/bower.svg" height="100px" style="margin:10px">
            <img src="<?= $logoUrl ?>/npm.svg" height="80px" style="margin:10px">
            <h3>Composer + Bower + NPM = friends forever!</h3>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>What is that?</h2>

                <p>This repository allows installation of Bower and NPM packages as native Composer packages.</p>
                <p><b>NO</b> plugins and <b>NO</b> Node.js are required.</p>

                <p>At the moment we've added most popular Bower and NPM packages 4000+ each.</p>
                <p>
                    In case Composer fails to install some asset package,
                    use the search line at the top of the page to check specific package health.
                </p>
                <p>For NPM scoped packages use `scope--package` instead of `@scope/package`, e.g. `npm-asset/pusher--chatkit`.</p>

                <p><?= Html::a('More info &raquo;', ['/site/about'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="col-lg-4">
                <h2>Usage</h2>

                <p>List required packages like the following:</p>
                <pre><code>"require": {
    "bower-asset/bootstrap": "^3.3",
    "npm-asset/jquery": "^2.2"
}</code></pre>

                <p>And add these lines:</p>
                <pre><code>"repositories": [
    {
        "type": "composer",
        "url": "https://asset-packagist.org"
    }
]</code></pre>
            </div>
            <div class="col-lg-4">
                <h2>Why?</h2>

                <p>Got tired of <code><a href="https://github.com/fxpio/composer-asset-plugin">fxp/composer-asset-plugin</a></code>.
                </p>
                <p>
                    It's a good project with nice idea and good implementation.
                    But it has some issues: it slows down <code>composer update</code> a lot and
                    requires global installation, so affects all projects. Also there are Travis
                    and Scrutinizer integration special problems, that are a bit annoying.
                </p>

                <p>Questions?</p>
                <p><?= Html::a('More info &raquo;', ['/site/contact'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>

    </div>
</div>

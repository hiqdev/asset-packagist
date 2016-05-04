<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['logo-text'];
?>
<div class="site-index">
    <div style="text-align:center;margin:30px 0px 20px">
        <div>
            <img src="/logo/composer.png" height="140px">
            <img src="/logo/bower.svg" height="100px" style="margin:10px">
            <img src="/logo/npm.svg" height="80px" style="margin:10px">
            <h3>Composer + Bower + NPM = friends forever!</h3>
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>What is that?</h2>

                <p>This repository allows installation of Bower and NPM packages as native Composer packages.</p>
                <p><b>NO</b> plugins and <b>NO</b> Node.js are required.</p>
                </p>

                <p><a class="btn btn-default" href="/site/about">More info &raquo;</a></p>
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
        "url": "https://asset-packagist.hiqdev.com"
    }
]</code></pre>
            </div>
            <div class="col-lg-4">
                <h2>Why?</h2>

                <p>Got tired of <code><a href="https://github.com/francoispluchino/composer-asset-plugin">fxp/composer-asset-plugin</a></code>.
                </p>
                <p>It's a good project with nice idea and good implementation.
                But it has issues. It is slow and requires global installation
                which introduces various problems. Travis and Scrutinizer integration
                problems are especially annoying.
                </p>
                <p>Questions? <a class="btn btn-default" href="/site/contact">Contact me! &raquo;</a></p>
            </div>
        </div>

    </div>
</div>

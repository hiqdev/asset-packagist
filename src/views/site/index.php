<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['logo-text'];
?>
<div class="site-index">
    <div class="jumbotron">
        <img src="https://getcomposer.org/img/logo-composer-transparent2.png" height="140px">
        <img src="http://bower.io/img/bower-logo.svg" height="100px" style="margin:10px">
        <img src="https://www.npmjs.com/static/images/npm-logo.svg" height="80px" style="margin:10px">
        <h3>Composer, Bower and NPM friends forever!</h3>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>What?</h2>

                <p>This repository allows installation of Bower and NPM packages with Composer.</p>
                <p>It's like a server-side <code><a href="https://github.com/francoispluchino/composer-asset-plugin">fxp/composer-asset-plugin</a></code>.</p>
                <p>But <b>NO</b> plugin and <b>NO</b> Node.js required.</p>
                </p>

                <p><a class="btn btn-default" href="/site/about">More info &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>How?</h2>

                <p>List required packages like this:</p>
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
                It's a cool thing anyway - good idea and decent realization.
                But it slows down composer and requires global installation which makes a lot of different probllems (Travis and Scrutinizer integration were most annoying for me).
                </p>
                <p>This repository solves all these problems.</p>
                <p><a class="btn btn-default" href="/site/contact">More questions? &raquo;</a></p>
            </div>
        </div>

    </div>
</div>

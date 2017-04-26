<?php

/* @var $this yii\web\View */

$this->title = 'About';

?>
<div class="site-about">
    <h1>How it works</h1>

    <p>Asset Packagist provides information about Bower and NPM packages in a similar way to Packagist does it for
        Composer packages.
        So when you run composer for your project with enabled Asset Packagist repository composer knows all the
        available releases of bower-asset and npm-asset packages and knows how to download their files.
    </p>

    <p>First we add Bower and NPM packages to our repository. Script collects package information and prepares JSON file
        in Packagist format.
        For example you can look what we have for Bower <code>moment</code> package:
    </p>

    <p><a href="/p/bower-asset/moment/latest.json">https://asset-packagist.org/p/bower-asset/moment/latest.json</a>
    <p>

    <p>The file contains description of all of the versions of the package in the following format:</p>

    <pre><code>
    "2.13.0.0": {
      "uid": 1000600,
      "name": "bower-asset/moment",
      "version": "2.13.0.0",
      "type": "bower-asset",
      "dist": {
        "type": "zip",
        "url": "https://api.github.com/repos/moment/moment/zipball/d6651c21c6131fbb5db891b60971357739015688",
        "reference": "d6651c21c6131fbb5db891b60971357739015688"
      },
      "source": {
        "type": "git",
        "url": "https://github.com/moment/moment.git",
        "reference": "d6651c21c6131fbb5db891b60971357739015688"
      }
    },
    </code></pre>

    <p>So when you run composer it downloads info about packages provided by Asset Packagist repository, then composer
        resolves dependencies and finds proper versions of required packages, then it downloads packages files to <code>vendor</code>
        directory of your project (actually composer doesn't care if these are PHP or JS or whatever files).</p>

    <p>All the JSON files are stored and served as static files on Asset Packagist side and composer effectively cashes
        those files on your side so everything works as quick as possible.</p>

    <h1>Installing to a custom path</h1>

    <p>Asset Packagist is NOT a plugin so it can't affect where the package will be installed.<br>
        By default <code>bower-asset/bootstrap</code> package will be installed to
        <code>vendor/bower-asset/bootstrap</code> folder.</p>

    <p>But you can achieve installing to custom path with <code><a
                    href="https://github.com/oomphinc/composer-installers-extender">oomphinc/composer-installers-extender</a></code>
        plugin like this:</p>
    <pre><code>
    "require": {
        "oomphinc/composer-installers-extender": "^1.1",
        "bower-asset/bootstrap": "^3.3",
        "npm-asset/jquery": "^2.2"
    },
    "extra": {
        "installer-types": ["bower-asset", "npm-asset"],
        "installer-paths": {
            "public/assets/{$vendor}/{$name}/": ["type:bower-asset", "type:npm-asset"],
        }
    },
    "repositories": [
        {
            "type": "composer",
            "url": "https://asset-packagist.org"
        }
    ]
    </code></pre>

    <h1>Yii2</h1>

    <p>Yii2 expects Bower and NPM packages to be installed to <code>vendor/bower</code> and <code>vendor/npm</code>
        folders respectively.</p>

    <p>So, to use asset-packagist for Yii2 projects it's necessary to reassign Bower and NPM aliases in your application
        config like this:</p>

    <pre><code>
    $config = [
        ...
        'aliases' =&gt; [
            '@bower' =&gt; '@vendor/bower-asset',
            '@npm'   =&gt; '@vendor/npm-asset',
        ],
        ...
    ];
    </code></pre>

    <h1>Acknowledgements</h1>

    <p>This project uses Francois Pluchino's <a href="https://github.com/fxpio/composer-asset-plugin">composer-asset-plugin</a>
        to convert Bower and NPM packages to Composer format.</p>
</div>

<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
?>
<div class="site-about">
    <h1>How it works</h1>

    <p>Asset Packagist provides information about Bower and NPM packages in a similar way to Packagist does it for Composer packages.
    So when you run composer for your project with enabled Asset Packagist repository composer knows all the available releases of bower-asset and npm-asset packages and knows how to download their files.
    </p>

    <p>First we add Bower and NPM packages to our repository. Script collects package information and prepares JSON file in Packagist format.
    For example you can look what we have for Bower <code>moment</code> package:
    </p>

    <p><a href="/p/bower-asset/moment/048aba286e6b54637154a7994fb004c5d9e5c044436bde744efa0ce914a87f8a.json">https://asset-packagist.org/p/bower-asset/moment/048aba286e6b54637154a7994fb004c5d9e5c044436bde744efa0ce914a87f8a.json</a>
    <p>

    <p>The file contains description of all of the versions of the package in the following format:</p>

    <pre><code>
    "2.13.0.0": {
      "uid": 1000600,
      "name": "bower-asset/moment",
      "version": "2.13.0.0",
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

    <p>So when you run composer it downloads info about packages provided by Asset Packagist repository, then composer resolves dependencies and finds proper versions of required packages, then it downloads packages files to <code>vendor</code> directory of your project (actually composer doesn't care if these are PHP or JS or whatever files).</p>

    <p>All the JSON files are stored and served as static files on Asset Packagist side and composer effectively cashes those files on your side so everything works as quick as possible.</p>

    <h1>Acknowledgements</h1>

    <p>This project uses Francois Pluchino's <a href="https://github.com/francoispluchino/composer-asset-plugin">composer-asset-plugin</a> to convert Bower and NPM packages to Composer format.</p>
</div>

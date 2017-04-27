<?php

namespace hiqdev\assetpackagist\exceptions;

use yii\base\Exception;

class PackageNotExistsException extends Exception implements PermanentProblemExceptionInterface
{
    public function getName()
    {
        return 'The package was not found';
    }
}

<?php

namespace hiqdev\assetpackagist\exceptions;

use yii\base\Exception;

class CorruptedPackageException extends Exception implements PermanentProblemExceptionInterface
{
    public function getName()
    {
        return 'The package is corrupted and can not be processed';
    }
}

<?php

namespace hiqdev\assetpackagist\exceptions;

use yii\base\Exception;

class UpdateRateLimitException extends Exception
{
    public function getName()
    {
        return 'The package can not be update too often';
    }
}

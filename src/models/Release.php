<?php

namespace hiqdev\assetpackagist\models;

use yii\base\Model;

class Release extends Model
{
    /**
     * @var string release UID
     */
    public $uid;

    /**
     * @var string release name
     */
    public $name;

    /**
     * @var string the release version
     */
    public $version;

    /**
     * @var array
     */
    public $dist;

    /**
     * @var array
     */
    public $source;

    /**
     * @var array release requirements
     */
    public $require;

    /**
     * @return bool whether the release is valid and can be used generally used
     */
    public function isValid()
    {
        return !empty($this->dist) || !empty($this->source);
    }
}

<?php

namespace hiqdev\assetpackagist\registry;

class RegistryFactory
{
    protected static $classes = [
        'bower' => BowerRegistry::class,
        'npm'   => NpmRegistry::class,
    ];

    static $registries = [];

    static public function getRegistry($type, $rm)
    {
        if (!isset(static::$registries[$type])) {
            static::$registries[$type] = static::buildRegistry($type, $rm);
        }

        return static::$registries[$type];
    }

    static protected function buildRegistry($type, $rm)
    {
        $config = [
            'repository-manager' => $rm,
            'asset-options'      => [],
        ];
        $rm->setRepositoryClass($type, static::$classes[$type]);

        return $rm->createRepository($type, $config);
    }
}
